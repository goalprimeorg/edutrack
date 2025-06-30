<?php

namespace App\Filament\WidgetHelper;

use App\Models\School;

class AnalyticColumnValue
{
    public static function column(?string $lga, ?string $school): array
    {

        return [
            'chart' => [
                'type' => 'bar',
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
        ];
    }

    public static function value(?string $lga, ?string $school)
    {
        $query = [];

        if ($lga) {
            $query['local_government_area_id'] = $lga;
        }
        if ($school) {
            $query['school_id'] = $school;
        }

        return School::where($query)->get()->toArray();
    }
}
