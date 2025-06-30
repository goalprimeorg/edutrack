<?php

namespace App\Filament\Partner\Resources\InventoryResource\Pages;

use App\Filament\Partner\Resources\InventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventory extends ViewRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
