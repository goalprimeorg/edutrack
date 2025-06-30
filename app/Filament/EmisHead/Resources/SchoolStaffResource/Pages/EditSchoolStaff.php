<?php

namespace App\Filament\EmisHead\Resources\SchoolStaffResource\Pages;

use App\Filament\EmisHead\Resources\SchoolStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolStaff extends EditRecord
{
    protected static string $resource = SchoolStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
