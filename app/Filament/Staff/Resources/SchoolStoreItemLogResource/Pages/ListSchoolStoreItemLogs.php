<?php

namespace App\Filament\Staff\Resources\SchoolStoreItemLogResource\Pages;

use App\Filament\Staff\Resources\SchoolStoreItemLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchoolStoreItemLogs extends ListRecords
{
    protected static string $resource = SchoolStoreItemLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
