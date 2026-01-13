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
        Schema::create('stories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('char_intro')->nullable();
            $table->text('char_details')->nullable();
            $table->text('part_one')->nullable();
            $table->text('part_two')->nullable();
            $table->text('part_three')->nullable();
            $table->text('part_four')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
