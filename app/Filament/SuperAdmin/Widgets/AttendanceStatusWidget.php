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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AttendanceStatusWidget extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'attendanceStatus';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Attendance Status Distribution by State and LGA';

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
            DatePicker::make('date_of_attendance')
                ->label('Date of Attendance')
                ->native(false)
                ->reactive()
                ->format('Y-m-d'),
        ];
    }

    /**
     * Get chart options for ApexCharts
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $data = $this->getAttendanceStatusData($this->filterFormData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
                'stacked' => true,
            ],
            'series' => [
                [
                    'name' => 'Present',
                    'data' => $data['present'],
                ],
                [
                    'name' => 'Absent',
                    'data' => $data['absent'],
                ],
                [
                    'name' => 'Late',
                    'data' => $data['late'],
                ],
                [
                    'name' => 'Sick',
                    'data' => $data['sick'],
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
            'colors' => ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0'],
        ];
    }

    /**
     * Fetch attendance status data based on filters
     *
     * @param array $filters
     * @return array
     */
    public function getAttendanceStatusData(array $filters): array
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
                DB::raw('COUNT(CASE WHEN student_attendances.attendance_status = "present" THEN 1 END) as present'),
                DB::raw('COUNT(CASE WHEN student_attendances.attendance_status = "absent" THEN 1 END) as absent'),
                DB::raw('COUNT(CASE WHEN student_attendances.attendance_status = "late" THEN 1 END) as late'),
                DB::raw('COUNT(CASE WHEN student_attendances.attendance_status = "sick" THEN 1 END) as sick')
            )
            ->whereNull('student_attendances.deleted_at');

        if (!$isSuperAdmin) {
            $query->where('s.id', $user->state_id); // Restrict to user's state
        } elseif ($filters['state_id'] ?? false) {
            $query->where('s.id', $filters['state_id']);
        }

        if ($filters['local_government_area_id'] ?? false) {
            $query->where('lga.id', $filters['local_government_area_id']);
        }

        if ($filters['date_of_attendance'] ?? false) {
            $query->where('sam.date_of_attendance', $filters['date_of_attendance']);
        }

        $results = $query->groupBy('s.id', 's.name', 'lga.id', 'lga.name')->get();

        Log::info('AttendanceStatusWidget: Fetched data', [
            'filters' => $filters,
            'results' => $results->toArray(),
        ]);

        return [
            'categories' => $results->map(fn($item) => "{$item->state} - {$item->lga}")->toArray(),
            'present' => $results->pluck('present')->toArray(),
            'absent' => $results->pluck('absent')->toArray(),
            'late' => $results->pluck('late')->toArray(),
            'sick' => $results->pluck('sick')->toArray(),
        ];
    }
}