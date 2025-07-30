<?php

namespace App\Filament\Staff\Resources\EmisResource\Pages;

use App\Filament\Staff\Resources\EmisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmis extends EditRecord
{
    protected static string $resource = EmisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
