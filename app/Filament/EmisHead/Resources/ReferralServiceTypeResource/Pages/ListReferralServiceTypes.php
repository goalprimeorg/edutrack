<?php

namespace App\Filament\EmisHead\Resources\ReferralServiceTypeResource\Pages;

use App\Filament\EmisHead\Resources\ReferralServiceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferralServiceTypes extends ListRecords
{
    protected static string $resource = ReferralServiceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
