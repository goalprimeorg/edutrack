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
        Schema::create('school_metrics', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->uuid('school_id')->index();
            $table->integer('total_no_male_students')->default(0);
            $table->integer('total_no_female_students')->default(0);
            $table->integer('total_no_disabled_male_students')->default(0);
            $table->integer('total_no_disabled_female_students')->default(0);
            $table->integer('total_no_male_staff')->default(0);
            $table->integer('total_no_female_staff')->default(0);
            $table->integer('total_no_disabled_male_staff')->default(0);
            $table->integer('total_no_disabled_female_staff')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_metrics');
    }
};
