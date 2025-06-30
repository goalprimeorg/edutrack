<?php

namespace App\Filament\SuperAdmin\Resources\IncidentTypeResource\Pages;

use App\Filament\SuperAdmin\Resources\IncidentTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIncidentType extends CreateRecord
{
    protected static string $resource = IncidentTypeResource::class;

    protected static bool $canCreateAnother = false;
}
