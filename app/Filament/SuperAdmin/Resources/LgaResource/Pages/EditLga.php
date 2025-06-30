<?php

namespace App\Filament\SuperAdmin\Resources\LgaResource\Pages;

use App\Filament\SuperAdmin\Resources\LgaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLga extends EditRecord
{
    protected static string $resource = LgaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
