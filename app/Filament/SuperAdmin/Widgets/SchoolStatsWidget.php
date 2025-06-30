<?php
namespace App\Filament\SuperAdmin\Widgets;

use App\Models\School;
use App\Models\Student;
use App\Models\SchoolStaff;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;


class SchoolStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        if ($isSuperAdmin) {
            return [
                Card::make('Total Schools', School::count()),
                Card::make('Total Students', Student::count()),
                Card::make('Total Staff', SchoolStaff::count()),
            ];
        }

        // For non-super-admin users, filter by their state
        $stateId = $user->state_id; // Assuming user has state_id

        return [
            Card::make('Total Schools', School::where('state_id', $stateId)->count()),
            Card::make('Total Students', Student::where('state_id', $stateId)->count()),
            Card::make('Total Staff', SchoolStaff::where('state_id', $stateId)->count()),
        ];
    }
}