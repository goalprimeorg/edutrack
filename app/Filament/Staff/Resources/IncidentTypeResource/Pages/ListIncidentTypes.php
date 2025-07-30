<?php

namespace App\Filament\Staff\Resources\IncidentTypeResource\Pages;

use App\Filament\Staff\Resources\IncidentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidentTypes extends ListRecords
{
    protected static string $resource = IncidentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
