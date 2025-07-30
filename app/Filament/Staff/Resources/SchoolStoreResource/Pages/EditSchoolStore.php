<?php

namespace App\Filament\Staff\Resources\SchoolStoreResource\Pages;

use App\Filament\Staff\Resources\SchoolStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolStore extends EditRecord
{
    protected static string $resource = SchoolStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
