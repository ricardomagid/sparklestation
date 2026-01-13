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
        Schema::create('char_abilities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('ability_id')->nullable()->index('char_abilities_ibfk_1');
            $table->integer('ability_type_id')->nullable()->index('char_abilities_ibfk_2');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('energy')->nullable();
            $table->string('toughness_reduction')->nullable();
            $table->json('differences')->nullable();
            $table->json('positions')->nullable();
            $table->integer('character_id')->nullable()->index('char_abilities_ibfk_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('char_abilities');
    }
};
