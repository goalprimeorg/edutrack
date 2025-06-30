<?php

namespace App\Filament\EmisHead\Resources\IncidentReportResource\Pages;

use App\Filament\EmisHead\Resources\IncidentReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIncidentReport extends CreateRecord
{
    protected static string $resource = IncidentReportResource::class;

    protected static bool $canCreateAnother = false;
}
