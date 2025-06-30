<?php

namespace App\Filament\SuperAdmin\Resources\EmisResource\Pages;

use App\Filament\SuperAdmin\Resources\EmisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmis extends EditRecord
{
    protected static string $resource = EmisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
