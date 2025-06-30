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
        Schema::table('notifications', function (Blueprint $table) {
                     // Drop the existing notifiable_id column
                     $table->dropColumn('notifiable_id');
                     // Add a new notifiable_id column as uuid
                     $table->uuid('notifiable_id')->after('id');
               
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn('notifiable_id');
            $table->unsignedBigInteger('notifiable_id')->after('id');
        });
    }
};
