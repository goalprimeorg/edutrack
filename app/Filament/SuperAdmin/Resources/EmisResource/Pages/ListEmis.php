<?php

namespace App\Filament\SuperAdmin\Resources\EmisResource\Pages;

use App\Filament\SuperAdmin\Resources\EmisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmis extends ListRecords
{
    protected static string $resource = EmisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
