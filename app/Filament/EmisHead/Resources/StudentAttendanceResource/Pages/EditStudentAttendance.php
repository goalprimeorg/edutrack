<?php

namespace App\Filament\EmisHead\Resources\StudentAttendanceResource\Pages;

use App\Filament\EmisHead\Resources\StudentAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentAttendance extends EditRecord
{
    protected static string $resource = StudentAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
