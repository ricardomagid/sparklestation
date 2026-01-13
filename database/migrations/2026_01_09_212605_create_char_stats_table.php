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
        Schema::create('char_stats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->double('atk')->nullable();
            $table->double('hp')->nullable();
            $table->double('def')->nullable();
            $table->integer('speed')->nullable();
            $table->double('crit_d')->nullable();
            $table->double('crit_r')->nullable();
            $table->string('taunt')->nullable();
            $table->integer('energy')->nullable();
            $table->integer('character_id')->nullable()->index('fk_character_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('char_stats');
    }
};
