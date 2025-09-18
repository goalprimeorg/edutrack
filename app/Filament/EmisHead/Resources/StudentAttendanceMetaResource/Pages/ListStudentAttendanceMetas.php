<?php

namespace App\Filament\EmisHead\Resources\StudentAttendanceMetaResource\Pages;

use App\Filament\EmisHead\Resources\StudentAttendanceMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentAttendanceMetas extends ListRecords
{
    protected static string $resource = StudentAttendanceMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
