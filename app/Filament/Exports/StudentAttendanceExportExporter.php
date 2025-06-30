<?php

namespace App\Filament\Exports;

use App\Models\StudentAttendanceExport;
use App\Models\StudentAttendance;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StudentAttendanceExportExporter extends Exporter
{
    protected static ?string $model = StudentAttendanceExport::class;


    public static function getColumns(): array
    {
        return [
            ExportColumn::make('attendanceMeta.school.name')
                ->label('School'),
            ExportColumn::make('student.student_id')
                ->label('Student ID'),
            ExportColumn::make('student.user.name')
                ->label('Student Name'),
            ExportColumn::make('attendanceMeta.classroom.classname')
                ->label('Classroom'),
            ExportColumn::make('attendanceMeta.date_of_attendance')
                ->label('Date'),
            ExportColumn::make('attendance_status')
                ->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student attendance export export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
