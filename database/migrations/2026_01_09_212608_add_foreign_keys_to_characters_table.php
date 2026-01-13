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
        Schema::table('characters', function (Blueprint $table) {
            $table->foreign(['path_id'], 'characters_ibfk_1')->references(['id'])->on('paths')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['patch_id'], 'characters_ibfk_2')->references(['id'])->on('patches')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['element_id'], 'characters_ibfk_3')->references(['id'])->on('elements')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['story_id'], 'characters_ibfk_4')->references(['id'])->on('stories')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['stats_id'], 'characters_ibfk_5')->references(['id'])->on('char_stats')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['faction_id'], 'characters_ibfk_6')->references(['id'])->on('factions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ascension_material_id'], 'characters_ibfk_8')->references(['id'])->on('materials')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['advanced_trace_id'], 'characters_ibfk_9')->references(['id'])->on('materials')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign('characters_ibfk_1');
            $table->dropForeign('characters_ibfk_2');
            $table->dropForeign('characters_ibfk_3');
            $table->dropForeign('characters_ibfk_4');
            $table->dropForeign('characters_ibfk_5');
            $table->dropForeign('characters_ibfk_6');
            $table->dropForeign('characters_ibfk_8');
            $table->dropForeign('characters_ibfk_9');
        });
    }
};
