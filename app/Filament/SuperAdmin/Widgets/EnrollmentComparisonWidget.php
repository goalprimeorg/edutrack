<?php

declare(strict_types=1);

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Student;
use App\Models\School;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnrollmentComparisonWidget extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'enrollmentComparison';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Student Enrollment by State, LGA, and School';

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
                ->reactive()
                ->searchable(),
            Select::make('school_id')
                ->label('School')
                ->options(function (Get $get) use ($user, $isSuperAdmin) {
                    $lgaId = $get('local_government_area_id');
                    if (!$lgaId) {
                        if (!$isSuperAdmin) {
                            return School::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        return School::pluck('name', 'id');
                    }
                    return School::where('local_government_area_id', $lgaId)
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
        $data = $this->getEnrollmentData($this->filterFormData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
                'stacked' => false,
            ],
            'series' => [
                [
                    'name' => 'Enrollment Count',
                    'data' => $data['enrollment_counts'],
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
                    'text' => 'Number of Students',
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
            'colors' => ['#36A2EB'],
        ];
    }

    /**
     * Fetch enrollment data based on filters
     *
     * @param array $filters
     * @return array
     */
    public function getEnrollmentData(array $filters): array
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $query = Student::query()
            ->join('states as s', 'students.state_id', '=', 's.id')
            ->join('local_government_areas as lga', 'students.local_government_area_id', '=', 'lga.id')
            ->join('classrooms as c', 'students.current_classroom_id', '=', 'c.id')
            ->join('schools as sch', 'c.school_id', '=', 'sch.id')
            ->select(
                's.name as state',
                'lga.name as lga',
                'sch.name as school',
                DB::raw('COUNT(students.id) as enrollment_count')
            )
            ->whereNull('students.deleted_at')
            ->groupBy('s.id', 's.name', 'lga.id', 'lga.name', 'sch.id', 'sch.name');

        if (!$isSuperAdmin) {
            $query->where('s.id', $user->state_id); // Restrict to user's state
        } elseif ($filters['state_id'] ?? false) {
            $query->where('s.id', $filters['state_id']);
        }

        if ($filters['local_government_area_id'] ?? false) {
            $query->where('lga.id', $filters['local_government_area_id']);
        }

        if ($filters['school_id'] ?? false) {
            $query->where('sch.id', $filters['school_id']);
        }

        $results = $query->get();

        Log::info('EnrollmentComparisonWidget: Fetched data', [
            'filters' => $filters,
            'results' => $results->toArray(),
        ]);

        return [
            'categories' => $results->map(fn($item) => "{$item->state} - {$item->lga} - {$item->school}")->toArray(),
            'enrollment_counts' => $results->pluck('enrollment_count')->toArray(),
        ];
    }
}