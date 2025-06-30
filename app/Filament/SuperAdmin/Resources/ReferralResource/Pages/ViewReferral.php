<?php

namespace App\Filament\SuperAdmin\Resources\ReferralResource\Pages;

use App\Filament\SuperAdmin\Resources\ReferralResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReferral extends ViewRecord
{
    protected static string $resource = ReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
