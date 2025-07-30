<?php

namespace App\Filament\Staff\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AnalyticLine extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'analyticLine';

    protected static bool $isLazy = false;

    /**
     * Widget Title
     */
    protected static ?string $heading = 'In-School & Drop-out Trend';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'In school',
                    'data' => [2, 4, 6, 10, 14, 7, 2, 9, 10, 15, 13, 18],
                ],
                [
                    'name' => 'Drop Out',
                    'data' => [8, 4, 20, 30, 4, 2, 7, 20, 40, 43, 23, 18],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b', '#f10e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
