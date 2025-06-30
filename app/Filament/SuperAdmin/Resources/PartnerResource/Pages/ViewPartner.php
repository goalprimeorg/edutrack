<?php

namespace App\Filament\SuperAdmin\Resources\PartnerResource\Pages;

use App\Filament\SuperAdmin\Resources\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPartner extends ViewRecord
{
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
