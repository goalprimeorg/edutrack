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
        Schema::create('student_distributions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('remark')->nullable();
            $table->uuid('distributed_by');
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_item_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
