<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_characters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('character_id');

            $table->unsignedTinyInteger('eidolon')
                ->default(0);

            $table->unsignedTinyInteger('copies_available')
                ->default(0);

            $table->timestamps();

            $table->unique([
                'user_id',
                'character_id'
            ]);

            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_characters');
    }
};