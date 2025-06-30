<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_attendances', function (Blueprint $table) {
            $table->dropColumn([
                'school_id',
                'marked_by_school_staff_id',
                'is_present',
                'date_of_attendance'
            ]);
            $table->uuid('student_attendance_meta_id')->index();
            $table->string('attendance_status')->default('present');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_attendances', function (Blueprint $table) {
            $table->uuid('school_id')->index();
            $table->uuid('marked_by_school_staff_id')->index();
            $table->boolean('is_present');
            $table->date('date_of_attendance');

            $table->dropColumn([
                'student_attendance_meta_id',
                'attendance_status'
            ]);
        });
    }
};
