<?php

namespace App\Filament\EmisHead\Resources\ReferralServiceTypeResource\Pages;

use App\Filament\EmisHead\Resources\ReferralServiceTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReferralServiceType extends CreateRecord
{
    protected static string $resource = ReferralServiceTypeResource::class;

    protected static bool $canCreateAnother = false;
}
