<?php

namespace App\Filament\SuperAdmin\Resources\StudentResource\Pages;

use App\Filament\SuperAdmin\Resources\StudentResource;
use App\Actions\Import\StudentImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('download')
            ->url('/student/export-excel-file')
            ->icon('heroicon-o-arrow-down-tray'),
            Actions\Action::make('import')
            ->form([
                FileUpload::make('students')
            ])
            ->action(function (array $data)  {
                $import = app(StudentImportAction::class);
                $import->execute($data);
            })
            ->icon('heroicon-o-arrow-up-tray'),
            
        ];
    }
}
