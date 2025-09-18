<?php

namespace App\Filament\EmisHead\Resources\StudentAttendanceMetaResource\Pages;

use App\Filament\EmisHead\Resources\StudentAttendanceMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentAttendanceMeta extends EditRecord
{
    protected static string $resource = StudentAttendanceMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
