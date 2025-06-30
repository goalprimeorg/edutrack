<?php

declare(strict_types=1);

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Student;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DisabilityRateWidget extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'disabilityRate';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Disabled Students by Gender, State, and LGA';

    /**
     * Lazy loading
     *
     * @var bool
     */
    protected static bool $isLazy = false;

    /**
     * Form schema for filters
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $stateOptions = $isSuperAdmin 
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id'); // Assuming user has state_id

        return [
            Select::make('state_id')
                ->label('State')
                ->options($stateOptions)
                ->reactive()
                ->searchable()
                ->visible($isSuperAdmin), // Only super-admin sees state filter
            Select::make('local_government_area_id')
                ->label('Local Government Area')
                ->options(function (Get $get) use ($user, $isSuperAdmin) {
                    if (!$isSuperAdmin) {
                        return LocalGovernmentArea::where('state_id', $user->state_id)
                            ->pluck('name', 'id');
                    }
                    
                    $stateId = $get('state_id');
                    if (!$stateId) {
                        return LocalGovernmentArea::pluck('name', 'id');
                    }
                    return LocalGovernmentArea::where('state_id', $stateId)
                        ->pluck('name', 'id');
                })
                ->searchable(),
        ];
    }

    /**
     * Get chart options for ApexCharts
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $data = $this->getDisabilityData($this->filterFormData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
                'stacked' => true,
            ],
            'series' => [
                [
                    'name' => 'Disabled Male',
                    'data' => $data['disabled_male'],
                ],
                [
                    'name' => 'Disabled Female',
                    'data' => $data['disabled_female'],
                ],
            ],
            'xaxis' => [
                'categories' => $data['categories'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Number of Disabled Students',
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '55%',
                ],
            ],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
            'tooltip' => [
                'y' => [
                    'formatter' => 'function(val) { return val + " students"; }',
                ],
            ],
            'colors' => ['#36A2EB', '#FF6384'],
        ];
    }

    /**
     * Fetch disability data based on filters
     *
     * @param array $filters
     * @return array
     */
    public function getDisabilityData(array $filters): array
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $query = Student::query()
            ->join('states as s', 'students.state_id', '=', 's.id')
            ->join('local_government_areas as lga', 'students.local_government_area_id', '=', 'lga.id')
            ->select(
                's.name as state',
                'lga.name as lga',
                DB::raw('COUNT(CASE WHEN students.gender = "male" AND students.is_student_disabled = "1" THEN 1 END) as disabled_male'),
                DB::raw('COUNT(CASE WHEN students.gender = "female" AND students.is_student_disabled = "1" THEN 1 END) as disabled_female')
            )
            ->whereNull('students.deleted_at')
            ->groupBy('s.id', 's.name', 'lga.id', 'lga.name');

        if (!$isSuperAdmin) {
            $query->where('s.id', $user->state_id); // Restrict to user's state
        } elseif ($filters['state_id'] ?? false) {
            $query->where('s.id', $filters['state_id']);
        }

        if ($filters['local_government_area_id'] ?? false) {
            $query->where('lga.id', $filters['local_government_area_id']);
        }

        $results = $query->get();

        Log::info('DisabilityRateWidget: Fetched data', [
            'filters' => $filters,
            'results' => $results->toArray(),
        ]);

        return [
            'categories' => $results->map(fn($item) => "{$item->state} - {$item->lga}")->toArray(),
            'disabled_male' => $results->pluck('disabled_male')->toArray(),
            'disabled_female' => $results->pluck('disabled_female')->toArray(),
        ];
    }
}