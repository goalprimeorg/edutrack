<?php

namespace App\Filament\Staff\Resources\ReferralResource\Pages;

use App\Filament\Staff\Resources\ReferralResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReferral extends CreateRecord
{
    protected static string $resource = ReferralResource::class;

    protected static bool $canCreateAnother = false;
}
