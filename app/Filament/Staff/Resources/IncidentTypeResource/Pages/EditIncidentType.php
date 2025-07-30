<?php

namespace App\Filament\Staff\Resources\IncidentTypeResource\Pages;

use App\Filament\Staff\Resources\IncidentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncidentType extends EditRecord
{
    protected static string $resource = IncidentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
