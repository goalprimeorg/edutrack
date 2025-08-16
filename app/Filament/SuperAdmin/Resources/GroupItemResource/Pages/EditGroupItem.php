<?php

namespace App\Filament\SuperAdmin\Resources\GroupItemResource\Pages;

use App\Filament\SuperAdmin\Resources\GroupItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupItem extends EditRecord
{
    protected static string $resource = GroupItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
