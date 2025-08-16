<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Group Items table
        Schema::create('group_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Group Item Details table
        Schema::create('group_item_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('group_item_id');
            $table->uuid('item_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('group_item_id')
                ->references('id')
                ->on('group_items')
                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_item_details');
        Schema::dropIfExists('group_items');
    }
};
