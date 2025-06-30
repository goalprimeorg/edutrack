<?php

namespace App\Filament\SuperAdmin\Resources\IncidentTypeResource\Pages;

use App\Filament\SuperAdmin\Resources\IncidentTypeResource;
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
