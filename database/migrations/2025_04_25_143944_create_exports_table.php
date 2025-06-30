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
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->string('exporter');
            $table->unsignedBigInteger('total_rows');
            $table->unsignedBigInteger('processed_rows');
            $table->unsignedBigInteger('successful_rows');
            $table->string('file_name')->nullable();
            $table->string('file_disk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exports');
    }
};
