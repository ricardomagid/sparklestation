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
        Schema::table('traces', function (Blueprint $table) {
            $table->foreign(['character_id'], 'traces_ibfk_1')->references(['id'])->on('characters')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traces', function (Blueprint $table) {
            $table->dropForeign('traces_ibfk_1');
        });
    }
};
