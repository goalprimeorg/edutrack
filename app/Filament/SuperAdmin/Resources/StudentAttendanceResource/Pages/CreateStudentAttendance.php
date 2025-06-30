<?php

namespace App\Filament\SuperAdmin\Resources\StudentAttendanceResource\Pages;

use App\Filament\SuperAdmin\Resources\StudentAttendanceResource;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentAttendanceMeta;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class CreateStudentAttendance extends CreateRecord
{
    protected static string $resource = StudentAttendanceResource::class;

    protected function handleRecordCreation(array $data): StudentAttendance
    {
        if ($data['select_all_students']) {
            // Get the StudentAttendanceMeta to find the classroom
            $meta = StudentAttendanceMeta::find($data['student_attendance_meta_id']);
            if (!$meta) {
                Notification::make()
                    ->title('Error')
                    ->body('Invalid Student Attendance Meta selected.')
                    ->danger()
                    ->send();
                return null;
            }

            // Get all students in the classroom
            $students = Student::where('current_classroom_id', $meta->classroom_id)->get();

            if ($students->isEmpty()) {
                Notification::make()
                    ->title('Warning')
                    ->body('No students found in the selected classroom.')
                    ->warning()
                    ->send();
                return null;
            }

            // Get existing attendance records for this meta
            $existingStudentIds = StudentAttendance::where('student_attendance_meta_id', $data['student_attendance_meta_id'])
                ->pluck('student_id')
                ->toArray();

            $createdCount = 0;
            $skippedStudents = [];

            // Create attendance records for students without existing records
            foreach ($students as $student) {
                if (!in_array($student->id, $existingStudentIds)) {
                    StudentAttendance::create([
                        'id' => (string) Str::uuid(),
                        'student_attendance_meta_id' => $data['student_attendance_meta_id'],
                        'student_id' => $student->id,
                        'attendance_status' => $data['attendance_status'],
                        'state_id' => $data['state_id'],
                        'local_government_area_id' => $data['local_government_area_id'],
                    ]);
                    $createdCount++;
                } else {
                    $skippedStudents[] = "{$student->first_name} {$student->last_name}";
                }
            }

            // Notify about results
            $message = "Created attendance for {$createdCount} student(s).";
            if (!empty($skippedStudents)) {
                $message .= " Skipped " . count($skippedStudents) . " student(s) with existing records: " . implode(', ', $skippedStudents);
            }
            Notification::make()
                ->title('Success')
                ->body($message)
                ->success()
                ->send();

            // Return a dummy record to satisfy Filament's expectation
            if ($createdCount > 0) {
                return StudentAttendance::create([
                    'id' => (string) Str::uuid(),
                    'student_attendance_meta_id' => $data['student_attendance_meta_id'],
                    'student_id' => $students->first()->id,
                    'attendance_status' => $data['attendance_status'],
                    'state_id' => $data['state_id'],
                    'local_government_area_id' => $data['local_government_area_id'],
                ]);
            }

            return null;
        }

        // Single student attendance
        $existing = StudentAttendance::where('student_attendance_meta_id', $data['student_attendance_meta_id'])
            ->where('student_id', $data['student_id'])
            ->exists();

        if ($existing) {
            $student = Student::find($data['student_id']);
            Notification::make()
                ->title('Warning')
                ->body("Attendance already recorded for {$student->first_name} {$student->last_name}.")
                ->warning()
                ->send();
            return null;
        }

        return StudentAttendance::create([
            'id' => (string) Str::uuid(),
            'student_attendance_meta_id' => $data['student_attendance_meta_id'],
            'student_id' => $data['student_id'],
            'attendance_status' => $data['attendance_status'],
            'state_id' => $data['state_id'],
            'local_government_area_id' => $data['local_government_area_id'],
        ]);
    }
}

