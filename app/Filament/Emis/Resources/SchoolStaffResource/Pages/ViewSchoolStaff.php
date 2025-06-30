<?php

namespace App\Filament\Emis\Resources\SchoolStaffResource\Pages;

use App\Filament\Emis\Resources\SchoolStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolStaff extends ViewRecord
{
    protected static string $resource = SchoolStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
