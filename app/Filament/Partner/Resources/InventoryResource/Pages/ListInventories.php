<?php

namespace App\Filament\Partner\Resources\InventoryResource\Pages;

use App\Actions\Import\InventoryImportAction;
use App\Filament\Partner\Resources\InventoryResource;
use App\Models\Inventory;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Get;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

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
