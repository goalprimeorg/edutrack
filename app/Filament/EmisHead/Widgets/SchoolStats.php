<?php

namespace App\Filament\EmisHead\Widgets;

use App\Filament\WidgetHelper\StatValue;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SchoolStats extends BaseWidget
{
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 4;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('total_no_male_students', StatValue::value('total_no_male_students'))
                ->label(__('Total No. of Male Students')),

            Stat::make('total_no_female_students', StatValue::value('total_no_female_students'))
                ->label(__('Total No. of Female Students')),

            Stat::make('total_no_disabled_male_students', StatValue::value('total_no_disabled_male_students'))
                ->label(__('Total No. of Disabled Male Students')),

            Stat::make('total_no_female_students', StatValue::value('total_no_female_students'))
                ->label(__('Total No. of Female Students')),

            Stat::make('total_no_male_staff', StatValue::value('total_no_male_staff'))
                ->label(__('Total No. of Male Staff')),

            Stat::make('total_no_female_staff', StatValue::value('total_no_male_staff'))
                ->label(__('Total No. of Female Staff')),

            Stat::make('total_no_disabled_male_staff', StatValue::value('total_no_disabled_male_staff'))
                ->label(__('Total No. of Disabled Male Staff')),

            Stat::make('total_no_female_staff', StatValue::value('total_no_female_staff'))
                ->label(__('Total No. of Female Staff')),
        ];
    }
}
