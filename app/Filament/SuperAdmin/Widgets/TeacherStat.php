<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\SchoolMetric;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\LocalGovernmentArea;
use App\Models\School;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

class TeacherStat extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'teacherStat';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total Teachers Statistics';

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

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $stat = $this->getStat($this->filterFormData);

        return [
            'chart' => [
                'type' => 'pie',
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

        $query = SchoolMetric::query();

        if ($filters['local_government_area_id'] ?? false) {
            $query->whereHas('school', function ($q) use ($filters) {
                $q->where('local_government_area_id', $filters['local_government_area_id']);
            });
        }

        if ($filters['school_id'] ?? false) {
            $query->where('school_id', $filters['school_id']);
        }

        // Fetch filtered metrics
        $metric = $query->get([
            'total_no_disabled_male_staff',
            'total_no_disabled_female_staff',
            'total_no_female_staff',
            'total_no_male_staff'
        ]);

        return [
            'maleD' => $metric->sum('total_no_disabled_male_staff'),
            'femaleD' => $metric->sum('total_no_disabled_female_staff'),
            'male' => $metric->sum('total_no_male_staff'),
            'female' => $metric->sum('total_no_female_staff')
        ];
    }
}
