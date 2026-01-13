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
        Schema::create('characters', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('rarity')->nullable();
            $table->integer('path_id')->nullable()->index('characters_ibfk_1');
            $table->integer('element_id')->nullable()->index('characters_ibfk_3');
            $table->integer('stats_id')->nullable()->index('characters_ibfk_5');
            $table->integer('patch_id')->nullable()->index('characters_ibfk_2');
            $table->integer('faction_id')->nullable()->index('characters_ibfk_6');
            $table->integer('story_id')->nullable()->index('characters_ibfk_4');
            $table->enum('gender', ['Male', 'Female', 'Non-binary', ''])->nullable();
            $table->string('enemy_material_group')->nullable()->index('characters_ibfk_7');
            $table->integer('ascension_material_id')->nullable()->index('characters_ibfk_8');
            $table->integer('advanced_trace_id')->nullable()->index('characters_ibfk_9');
            $table->string('image_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
