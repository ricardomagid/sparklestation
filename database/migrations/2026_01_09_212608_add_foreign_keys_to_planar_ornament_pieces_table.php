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
        Schema::table('planar_ornament_pieces', function (Blueprint $table) {
            $table->foreign(['planar_ornament_id'], 'planar_ornament_pieces_ibfk_1')->references(['id'])->on('planar_ornaments')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['relic_type'], 'planar_ornament_pieces_ibfk_2')->references(['id'])->on('relic_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planar_ornament_pieces', function (Blueprint $table) {
            $table->dropForeign('planar_ornament_pieces_ibfk_1');
            $table->dropForeign('planar_ornament_pieces_ibfk_2');
        });
    }
};
