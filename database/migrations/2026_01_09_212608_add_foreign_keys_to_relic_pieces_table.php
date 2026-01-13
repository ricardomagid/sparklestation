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
        Schema::table('relic_pieces', function (Blueprint $table) {
            $table->foreign(['relic_id'], 'relic_pieces_ibfk_1')->references(['id'])->on('relics')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['relic_type'], 'relic_pieces_ibfk_2')->references(['id'])->on('relic_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relic_pieces', function (Blueprint $table) {
            $table->dropForeign('relic_pieces_ibfk_1');
            $table->dropForeign('relic_pieces_ibfk_2');
        });
    }
};
