<?php

namespace App\Filament\EmisHead\Resources\RequestResource\Pages;

use App\Filament\EmisHead\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequest extends EditRecord
{
    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
