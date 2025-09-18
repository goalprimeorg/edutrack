<?php

namespace App\Filament\Staff\Resources\SchoolStoreResource\Pages;

use App\Filament\Staff\Resources\SchoolStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchoolStores extends ListRecords
{
    protected static string $resource = SchoolStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
