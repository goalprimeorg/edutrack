<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_attendances', function (Blueprint $table) {
            $table->char('state_id', 36)->nullable()->after('attendance_status');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('restrict');
            $table->char('local_government_area_id', 36)->nullable()->after('state_id');
            $table->foreign('local_government_area_id')->references('id')->on('local_government_areas')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('student_attendances', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropForeign(['local_government_area_id']);
            $table->dropColumn(['state_id', 'local_government_area_id']);
        });
    }
};