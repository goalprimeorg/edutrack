<?php

namespace App\Filament\Staff\Resources\StudentAttendanceMetaResource\Pages;

use App\Filament\Staff\Resources\StudentAttendanceMetaResource;
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
