<?php

namespace App\Filament\SuperAdmin\Resources\SchoolStoreResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolStore extends ViewRecord
{
    protected static string $resource = SchoolStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
