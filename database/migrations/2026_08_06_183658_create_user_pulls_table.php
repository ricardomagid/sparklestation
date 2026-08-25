<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_pulls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('item_type'); // character or lightcone
            $table->unsignedBigInteger('item_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_pulls');
    }
};
