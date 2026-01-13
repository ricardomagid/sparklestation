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
        Schema::table('user_relic_stats', function (Blueprint $table) {
            $table->foreign(['stat_id'], 'fk_user_relic_stats_relic_stats')->references(['id'])->on('relic_stats')->onUpdate('no action')->onDelete('restrict');
            $table->foreign(['user_relic_id'], 'fk_user_relic_stats_user_relic')->references(['id'])->on('user_relics')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_relic_stats', function (Blueprint $table) {
            $table->dropForeign('fk_user_relic_stats_relic_stats');
            $table->dropForeign('fk_user_relic_stats_user_relic');
        });
    }
};
