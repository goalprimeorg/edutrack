<?php

namespace App\Filament\SuperAdmin\Resources\EmisHeadResource\Pages;

use App\Filament\SuperAdmin\Resources\EmisHeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmisHeads extends ListRecords
{
    protected static string $resource = EmisHeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
