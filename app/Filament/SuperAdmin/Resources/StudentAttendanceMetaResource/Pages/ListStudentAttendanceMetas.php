<?php

namespace App\Filament\SuperAdmin\Resources\StudentAttendanceMetaResource\Pages;

use App\Filament\SuperAdmin\Resources\StudentAttendanceMetaResource;
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
