<?php

declare(strict_types=1);

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\StudentAttendance;
use App\Models\StudentAttendanceMeta;
use App\Models\School;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AttendanceComparisonWidget extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'attendanceComparison';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Attendance Rate by State and LGA';

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
        $data = $this->getAttendanceData($this->filterFormData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
                'stacked' => false,
            ],
            'series' => [
                [
                    'name' => 'Attendance Rate (%)',
                    'data' => $data['attendance_rates'],
                ]
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
                'max' => 100,
                'title' => [
                    'text' => 'Attendance Rate (%)',
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
                    'formatter' => 'function(val) { return val.toFixed(2) + "%"; }',
                ],
            ],
            'colors' => ['#36A2EB', '#FF6384', '#FFCE56'],
        ];
    }

    /**
     * Fetch attendance data based on filters
     *
     * @param array $filters
     * @return array
     */
    public function getAttendanceData(array $filters): array
    {
       
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $query = StudentAttendance::query()
            ->join('student_attendance_metas as sam', 'student_attendances.student_attendance_meta_id', '=', 'sam.id')
            ->join('schools as sch', 'sam.school_id', '=', 'sch.id')
            ->join('states as s', 'sch.state_id', '=', 's.id')
            ->join('local_government_areas as lga', 'sch.local_government_area_id', '=', 'lga.id')
            ->select(
                's.name as state',
                'lga.name as lga',
                DB::raw('(COUNT(CASE WHEN student_attendances.attendance_status = "present" THEN 1 END) / COUNT(student_attendances.id) * 100) as attendance_rate')
            )
            ->whereNull('student_attendances.deleted_at')
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

        return [
            'categories' => $results->map(fn($item) => "{$item->state} - {$item->lga}")->toArray(),
            'attendance_rates' => $results->pluck('attendance_rate')->toArray(),
        ];
    }
}