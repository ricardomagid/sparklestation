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
        Schema::create('materials', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('material_group')->nullable();
            $table->integer('rarity')->nullable();
            $table->integer('type_id')->nullable()->index('materials_ibfk_3');
            $table->double('patch')->nullable();
            $table->integer('element_id')->nullable()->index('materials_ibfk_1');
            $table->integer('path_id')->nullable()->index('materials_ibfk_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
