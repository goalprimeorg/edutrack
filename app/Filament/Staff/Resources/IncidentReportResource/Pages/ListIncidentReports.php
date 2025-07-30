<?php

namespace App\Filament\Staff\Resources\IncidentReportResource\Pages;

use App\Filament\Staff\Resources\IncidentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidentReports extends ListRecords
{
    protected static string $resource = IncidentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
