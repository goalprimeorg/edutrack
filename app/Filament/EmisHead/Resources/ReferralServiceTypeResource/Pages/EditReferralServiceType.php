<?php

namespace App\Filament\EmisHead\Resources\ReferralServiceTypeResource\Pages;

use App\Filament\EmisHead\Resources\ReferralServiceTypeResource;
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
