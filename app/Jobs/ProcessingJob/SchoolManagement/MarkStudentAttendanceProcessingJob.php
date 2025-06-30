<?php

namespace App\Jobs\ProcessingJob\SchoolManagement;

use App\Actions\StudentAttendance\CreateStudentAttendanceAction;
use App\Actions\StudentAttendanceMeta\CreateStudentAttendanceMetaAction;
use App\Actions\StudentAttendanceMeta\GetDistinctStudentAttendanceMetaAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class MarkStudentAttendanceProcessingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $markStudentAttendanceOptions)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {

            $getDistinctStudentAttendanceMetaAction = app(GetDistinctStudentAttendanceMetaAction::class);
            $createStudentAttendanceAction = app(CreateStudentAttendanceAction::class);
            $createStudentAttendanceMetaAction = app(CreateStudentAttendanceMetaAction::class);

            $schoolId = $this->markStudentAttendanceOptions['school_id'];
            $classroomId = $this->markStudentAttendanceOptions['classroom_id'];
            $studentAttendances = $this->markStudentAttendanceOptions['student_attendances'];
            $dateOfAttendance = $this->markStudentAttendanceOptions['date_of_attendance'];
            $markedBySchoolStaffId = $this->markStudentAttendanceOptions['marked_by_school_staff_id'];
            
            
            $studentAttendanceMeta = $getDistinctStudentAttendanceMetaAction->execute([
                'school_id' => $schoolId,
                'classroom_id' => $classroomId,
                'date_of_attendance' => $dateOfAttendance,
            ]);

            if(is_null($studentAttendanceMeta)) {
                $studentAttendanceMeta = $createStudentAttendanceMetaAction->execute([
                    'school_id' => $schoolId,
                    'classroom_id' => $classroomId,
                    'date_of_attendance' => $dateOfAttendance,
                    'marked_by_school_staff_id' => $markedBySchoolStaffId,
                ]);
            }

            foreach ($studentAttendances as $studentAttendance) {
                $createStudentAttendanceAction->execute([
                    'student_attendance_meta_id' => $studentAttendanceMeta->id,
                    'student_id' => $studentAttendance['student_id'],
                    'attendance_status' => $studentAttendance['attendance_status'],
                ]);
            }
        });
    }
}
