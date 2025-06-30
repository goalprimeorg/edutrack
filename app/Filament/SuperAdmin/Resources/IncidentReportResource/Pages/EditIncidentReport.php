<?php

namespace App\Filament\SuperAdmin\Resources\IncidentReportResource\Pages;

use App\Filament\SuperAdmin\Resources\IncidentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncidentReport extends EditRecord
{
    protected static string $resource = IncidentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
