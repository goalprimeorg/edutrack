<?php

namespace App\Filament\SuperAdmin\Resources\IncidentTypeResource\Pages;

use App\Filament\SuperAdmin\Resources\IncidentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIncidentType extends ViewRecord
{
    protected static string $resource = IncidentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
