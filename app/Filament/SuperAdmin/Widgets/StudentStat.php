<?php
declare(strict_types=1);

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Student;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\LocalGovernmentArea;
use App\Models\School;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

class StudentStat extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'studentStat';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total Students Statistics';

    protected static bool $isLazy = false;

    protected function getFormSchema(): array
    {
        return [
            Select::make('local_government_area_id')
                ->label('Local Government Area')
                ->options(LocalGovernmentArea::all()->pluck('name', 'id'))
                ->searchable(),

            Select::make('school_id')
                ->label('School')
                ->options(function (Get $get) {
                    return School::where('local_government_area_id', $get('local_government_area_id'))
                        ->pluck('name', 'id');
                })
                ->searchable(),
        ];
    }

    protected function getOptions(): array
    {
        $stat = $this->getStat($this->filterFormData);

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 500,
            ],
            'series' => [
                $stat['male'],
                $stat['female'],
                $stat['maleD'],
                $stat['femaleD'],
            ],
            'labels' => [
                'Male',
                'Female',
                'Male with disability',
                'Female with disability',
            ],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }

    public function getStat(array $filters): array
    {
        $baseQuery = Student::query();

        if ($filters['local_government_area_id'] ?? false) {
            $baseQuery->whereHas('school', function ($q) use ($filters) {
                $q->where('local_government_area_id', $filters['local_government_area_id']);
            });
        }

        if ($filters['school_id'] ?? false) {
            $baseQuery->where('school_id', $filters['school_id']);
        }

        return [
            'male'    => (clone $baseQuery)->where('gender', 'Male')->count(),
            'female'  => (clone $baseQuery)->where('gender', 'Female')->count(),
            'maleD'   => (clone $baseQuery)->where('gender', 'Male')->where('is_student_disabled', '1')->count(),
            'femaleD' => (clone $baseQuery)->where('gender', 'Female')->where('is_student_disabled', '1')->count(),
        ];
    }
}
