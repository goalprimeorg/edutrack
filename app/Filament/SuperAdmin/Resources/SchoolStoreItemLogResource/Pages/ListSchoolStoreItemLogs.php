<?php

namespace App\Filament\SuperAdmin\Resources\SchoolStoreItemLogResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolStoreItemLogResource;
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
