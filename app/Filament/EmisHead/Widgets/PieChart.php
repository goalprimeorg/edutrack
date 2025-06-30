<?php

namespace App\Filament\EmisHead\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PieChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'pieChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Pie Chart';

    protected static bool $isLazy = false;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 500,
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
