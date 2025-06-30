<?php

namespace App\Filament\SuperAdmin\Resources\InventoryResource\Pages;

use App\Actions\Import\InventoryImportAction;
use App\Filament\SuperAdmin\Resources\InventoryResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('download')
                ->url('/inventory/export-excel-file')
                ->icon('heroicon-o-arrow-down-tray'),

            Actions\Action::make('import')
                ->form([
                    FileUpload::make('inventories')
                ])
                ->action(function (array $data)  {
                    $import = app(InventoryImportAction::class);
                    $import->execute($data);
                })
                ->icon('heroicon-o-arrow-up-tray'),
        ];
    }
}
