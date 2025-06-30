<?php

namespace App\Filament\Partner\Resources\InventoryResource\Pages;

use App\Filament\Partner\Resources\InventoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;

    protected static bool $canCreateAnother = false;
}
