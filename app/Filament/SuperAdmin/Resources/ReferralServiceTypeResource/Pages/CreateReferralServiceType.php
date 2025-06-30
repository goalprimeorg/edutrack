<?php

namespace App\Filament\SuperAdmin\Resources\ReferralServiceTypeResource\Pages;

use App\Filament\SuperAdmin\Resources\ReferralServiceTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReferralServiceType extends CreateRecord
{
    protected static string $resource = ReferralServiceTypeResource::class;

    protected static bool $canCreateAnother = false;
}
