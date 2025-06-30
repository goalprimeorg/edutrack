<?php

namespace App\Filament\EmisHead\Resources\IncidentReportResource\Pages;

use App\Filament\EmisHead\Resources\IncidentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIncidentReport extends ViewRecord
{
    protected static string $resource = IncidentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
