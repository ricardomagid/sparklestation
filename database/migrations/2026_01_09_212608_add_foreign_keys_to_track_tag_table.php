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
        Schema::table('track_tag', function (Blueprint $table) {
            $table->foreign(['tag_id'], 'track_tag_ibfk_1')->references(['id'])->on('tags')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['track_id'], 'track_tag_ibfk_2')->references(['id'])->on('tracks')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('track_tag', function (Blueprint $table) {
            $table->dropForeign('track_tag_ibfk_1');
            $table->dropForeign('track_tag_ibfk_2');
        });
    }
};
