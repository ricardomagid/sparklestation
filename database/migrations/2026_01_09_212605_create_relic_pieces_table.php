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
        Schema::create('relic_pieces', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique('slug');
            $table->text('description')->nullable();
            $table->text('story')->nullable();
            $table->integer('relic_type')->nullable()->index('relic_pieces_ibfk_2');
            $table->integer('relic_id')->nullable()->index('relic_pieces_ibfk_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relic_pieces');
    }
};
