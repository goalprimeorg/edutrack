<?php

namespace App\Filament\Partner\Resources\ShipmentResource\Pages;

use App\Filament\Partner\Resources\ShipmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    protected static bool $canCreateAnother = false;
}
