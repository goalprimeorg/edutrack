<?php

namespace App\Filament\SuperAdmin\Resources\LgaResource\Pages;

use App\Filament\SuperAdmin\Resources\LgaResource;
use Filament\Actions;
use App\Actions\Import\LgaImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;

class ListLgas extends ListRecords
{
    protected static string $resource = LgaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('download')
            ->url('/lga/export-excel-file')
            ->icon('heroicon-o-arrow-down-tray'),
            Actions\Action::make('import')
            ->form([
                FileUpload::make('local_government_areas')
            ])
            ->action(function (array $data)  {
                $import = app(LgaImportAction::class);
                $import->execute($data);
            })
            ->icon('heroicon-o-arrow-up-tray'),
        ];
    }
}
