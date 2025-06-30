<?php

namespace App\Filament\SuperAdmin\Resources\EmisResource\Pages;

use App\Filament\SuperAdmin\Resources\EmisResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmis extends ViewRecord
{
    protected static string $resource = EmisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
