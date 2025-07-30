<?php

namespace App\Filament\Staff\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AnalyticDonot extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'analyticDonot';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'AnalyticDonot';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [2, 4, 6, 10, 14],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
