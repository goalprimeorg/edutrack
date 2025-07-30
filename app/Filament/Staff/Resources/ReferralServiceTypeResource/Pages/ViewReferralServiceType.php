<?php

namespace App\Filament\Staff\Resources\ReferralServiceTypeResource\Pages;

use App\Filament\Staff\Resources\ReferralServiceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReferralServiceType extends ViewRecord
{
    protected static string $resource = ReferralServiceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
