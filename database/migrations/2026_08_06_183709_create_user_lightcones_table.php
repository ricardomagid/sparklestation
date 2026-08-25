<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_lightcones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('lightcone_id');

            $table->unsignedTinyInteger('superimposition')
                ->default(1);

            $table->unsignedTinyInteger('copies_available')
                ->default(0);

            $table->timestamps();

            $table->unique([
                'user_id',
                'lightcone_id'
            ]);

            $table->foreign('lightcone_id')
                ->references('id')
                ->on('lightcones')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_lightcones');
    }
};