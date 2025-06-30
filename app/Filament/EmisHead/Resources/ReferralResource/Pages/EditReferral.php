<?php

namespace App\Filament\EmisHead\Resources\ReferralResource\Pages;

use App\Filament\EmisHead\Resources\ReferralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferral extends EditRecord
{
    protected static string $resource = ReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
