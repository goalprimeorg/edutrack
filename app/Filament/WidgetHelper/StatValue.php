<?php

namespace App\Filament\WidgetHelper;

use App\Models\SchoolMetric;

class StatValue
{
    public static function value(string $column)
    {
        return SchoolMetric::all()->get($column)?->count() ?? 0;
    }
}
