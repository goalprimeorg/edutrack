<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create states table
        Schema::create('states', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name', 255)->unique();
            $table->timestamps();
        });

        // Update schools table: replace state with state_id
        Schema::table('schools', function (Blueprint $table) {
            $table->char('state_id', 36)->nullable()->after('name');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('restrict');
           
        });
    }

    public function down(): void
    {
        // Revert schools table
        Schema::table('schools', function (Blueprint $table) {
            $table->string('state', 255)->nullable()->after('name');
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
        });

        // Drop states table
        Schema::dropIfExists('states');
    }
};
