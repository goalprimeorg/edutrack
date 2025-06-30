<?php

namespace App\Filament\SuperAdmin\Resources\ShipmentResource\Pages;

use App\Filament\SuperAdmin\Resources\ShipmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    protected static bool $canCreateAnother = false;
}
