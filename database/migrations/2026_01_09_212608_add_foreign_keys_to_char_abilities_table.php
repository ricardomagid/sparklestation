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
        Schema::table('char_abilities', function (Blueprint $table) {
            $table->foreign(['ability_id'], 'char_abilities_ibfk_1')->references(['id'])->on('abilities')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ability_type_id'], 'char_abilities_ibfk_2')->references(['id'])->on('ability_types')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['character_id'], 'char_abilities_ibfk_3')->references(['id'])->on('characters')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('char_abilities', function (Blueprint $table) {
            $table->dropForeign('char_abilities_ibfk_1');
            $table->dropForeign('char_abilities_ibfk_2');
            $table->dropForeign('char_abilities_ibfk_3');
        });
    }
};
