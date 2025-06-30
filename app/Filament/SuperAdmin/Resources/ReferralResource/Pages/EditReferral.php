<?php

namespace App\Filament\SuperAdmin\Resources\ReferralResource\Pages;

use App\Filament\SuperAdmin\Resources\ReferralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferral extends EditRecord
{
    protected static string $resource = ReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
