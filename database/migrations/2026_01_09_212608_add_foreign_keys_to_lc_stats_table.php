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
        Schema::table('lc_stats', function (Blueprint $table) {
            $table->foreign(['lightcone_id'], 'fk_lightcone_id')->references(['id'])->on('lightcones')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lc_stats', function (Blueprint $table) {
            $table->dropForeign('fk_lightcone_id');
        });
    }
};
