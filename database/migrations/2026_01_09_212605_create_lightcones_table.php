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
        Schema::create('lightcones', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->integer('rarity')->nullable();
            $table->integer('path_id')->nullable()->index('lightcones_ibfk_4');
            $table->integer('stats_id')->nullable()->index('lightcones_ibfk_5');
            $table->integer('skill_id')->nullable()->index('lightcones_ibfk_1');
            $table->integer('patch_id')->nullable()->index('lightcones_ibfk_3');
            $table->text('story')->nullable();
            $table->string('enemy_material_group')->nullable();
            $table->string('image_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lightcones');
    }
};
