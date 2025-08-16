<?php

namespace App\Filament\SuperAdmin\Resources\GroupItemResource\Pages;

use App\Filament\SuperAdmin\Resources\GroupItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGroupItem extends CreateRecord
{
    protected static string $resource = GroupItemResource::class;

    protected function afterCreate(): void
{
    foreach ($this->record->details as $detail) {
        $detail->update([
            'group_item_id' => $this->record->id
        ]);
    }
}

}
