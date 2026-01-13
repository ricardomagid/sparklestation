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
        Schema::create('patches', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->double('number')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('image_link')->nullable();
            $table->unsignedInteger('story_arc_id')->nullable()->index('fk_story_arc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patches');
    }
};
