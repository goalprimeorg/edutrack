<?php

namespace App\Filament\SuperAdmin\Resources\SchoolStaffResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolStaffResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolStaff extends ViewRecord
{
    protected static string $resource = SchoolStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->color('danger'),
        ];
    }
}
