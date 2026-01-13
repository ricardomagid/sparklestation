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
        Schema::table('char_stats', function (Blueprint $table) {
            $table->foreign(['character_id'], 'fk_character_id')->references(['id'])->on('characters')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('char_stats', function (Blueprint $table) {
            $table->dropForeign('fk_character_id');
        });
    }
};
