<?php

namespace App\Filament\SuperAdmin\Resources\StudentAttendanceMetaResource\Pages;

use App\Filament\SuperAdmin\Resources\StudentAttendanceMetaResource;
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
