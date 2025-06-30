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
        Schema::table('emis', function (Blueprint $table) {
            $table->char('state_id', 36)->nullable()->after('password');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emis', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn(['state_id']);
        });
    }
};
