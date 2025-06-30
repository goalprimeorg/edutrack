<?php

namespace App\Filament\EmisHead\Resources\SchoolResource\Pages;

use App\Filament\EmisHead\Resources\SchoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchools extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
