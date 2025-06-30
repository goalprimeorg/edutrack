<?php

namespace App\Filament\EmisHead\Resources\ReferralResource\Pages;

use App\Filament\EmisHead\Resources\ReferralResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferrals extends ListRecords
{
    protected static string $resource = ReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
