<?php

namespace App\Filament\SuperAdmin\Resources\ReferralResource\Pages;

use App\Filament\SuperAdmin\Resources\ReferralResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReferral extends CreateRecord
{
    protected static string $resource = ReferralResource::class;

    protected static bool $canCreateAnother = false;
}
