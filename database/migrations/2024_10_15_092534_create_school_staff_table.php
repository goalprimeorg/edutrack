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
        Schema::create('school_staff', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->uuid('school_id')->index();
            $table->string('role')->default('teacher');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('password');
            $table->string('gender')->nullable();
            $table->boolean('is_staff_disabled')->nullable();
            $table->text('disability')->nullable();
            $table->string('profile_photo_url')->nullable();
            $table->string('level')->nullable();
            $table->uuid('highest_qualification_id')->nullable();
            $table->text('trainings_attended')->nullable();
            $table->boolean('has_system_generated_password')->default(true);
            $table->timestamp('last_login_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_staff');
    }
};
