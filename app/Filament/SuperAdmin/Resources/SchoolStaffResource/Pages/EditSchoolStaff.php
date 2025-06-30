<?php

namespace App\Filament\SuperAdmin\Resources\SchoolStaffResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolStaff extends EditRecord
{
    protected static string $resource = SchoolStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
