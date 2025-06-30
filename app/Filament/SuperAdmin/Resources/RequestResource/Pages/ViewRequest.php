<?php

namespace App\Filament\SuperAdmin\Resources\RequestResource\Pages;

use App\Filament\SuperAdmin\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRequest extends ViewRecord
{
    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
