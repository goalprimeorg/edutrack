<?php

namespace App\Filament\EmisHead\Resources\SchoolStoreItemLogResource\Pages;

use App\Filament\EmisHead\Resources\SchoolStoreItemLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolStoreItemLog extends EditRecord
{
    protected static string $resource = SchoolStoreItemLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
