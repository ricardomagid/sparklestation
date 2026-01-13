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
        Schema::table('lightcones', function (Blueprint $table) {
            $table->foreign(['skill_id'], 'lightcones_ibfk_1')->references(['id'])->on('lc_skills')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['patch_id'], 'lightcones_ibfk_3')->references(['id'])->on('patches')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['path_id'], 'lightcones_ibfk_4')->references(['id'])->on('paths')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['stats_id'], 'lightcones_ibfk_5')->references(['id'])->on('lc_stats')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lightcones', function (Blueprint $table) {
            $table->dropForeign('lightcones_ibfk_1');
            $table->dropForeign('lightcones_ibfk_3');
            $table->dropForeign('lightcones_ibfk_4');
            $table->dropForeign('lightcones_ibfk_5');
        });
    }
};
