<?php

namespace App\Filament\EmisHead\Pages;

use App\Filament\SuperAdmin\Widgets;
use App\Filament\EmisHead\Widgets\AnalyticColumn;
use App\Filament\EmisHead\Widgets\AnalyticDonot;
use App\Filament\EmisHead\Widgets\AnalyticLine;
use App\Filament\EmisHead\Widgets\PieChart;
use App\Filament\EmisHead\Widgets\SchoolStats;
use App\Models\LocalGovernmentArea;
use App\Models\School;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Page;

class Dashboard extends Page
{
    use BaseDashboard\Concerns\HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.emis-head.pages.dashboard';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('local_government_area_id')
                            ->label('Local Government Area')
                            ->options(LocalGovernmentArea::all()->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('school_id')
                            ->label('School')
                            ->options(School::all()->pluck('name', 'id'))
                            ->searchable(),
                    ])->columns(2),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
//            SchoolStats::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            Widgets\SchoolStatsWidget::class,
            Widgets\TeacherStat::class,
            Widgets\StudentStat::class,
            Widgets\AttendanceComparisonWidget::class,
            Widgets\AttendanceStatusWidget::class,
            Widgets\EnrollmentComparisonWidget::class,
            Widgets\DisabilityRateWidget::class,
            AnalyticColumn::class,
            AnalyticLine::class,
            AnalyticDonot::class,
            PieChart::class,
        ];
    }

    public function getFooterWidgetsColumns(): int|array
    {
        return 2;
    }
}
