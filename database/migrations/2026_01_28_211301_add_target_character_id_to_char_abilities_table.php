<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('char_abilities', function (Blueprint $table) {
            $table->unsignedInteger('target_character_id')->nullable();

            $table->foreign('target_character_id', 'char_abilities_ibfk_4')
                ->references('id')
                ->on('characters')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('char_abilities', function (Blueprint $table) {
            $table->dropForeign(['char_abilities_ibfk_4']);
            $table->dropColumn('target_character_id');
        });
    }
};
