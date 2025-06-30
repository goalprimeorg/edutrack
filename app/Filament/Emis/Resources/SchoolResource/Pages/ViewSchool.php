<?php

namespace App\Filament\Emis\Resources\SchoolResource\Pages;

use App\Filament\Emis\Resources\SchoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSchool extends ViewRecord
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
