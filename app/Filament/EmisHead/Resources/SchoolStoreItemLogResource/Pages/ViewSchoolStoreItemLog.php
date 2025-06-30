<?php

namespace App\Filament\EmisHead\Resources\SchoolStoreItemLogResource\Pages;

use App\Filament\EmisHead\Resources\SchoolStoreItemLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolStoreItemLog extends ViewRecord
{
    protected static string $resource = SchoolStoreItemLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
