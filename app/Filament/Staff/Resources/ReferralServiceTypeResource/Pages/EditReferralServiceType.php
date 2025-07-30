<?php

namespace App\Filament\Staff\Resources\ReferralServiceTypeResource\Pages;

use App\Filament\Staff\Resources\ReferralServiceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferralServiceType extends EditRecord
{
    protected static string $resource = ReferralServiceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
