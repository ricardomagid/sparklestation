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
        Schema::table('eidolons', function (Blueprint $table) {
            $table->foreign(['character_id'], 'eidolons_ibfk_1')->references(['id'])->on('characters')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eidolons', function (Blueprint $table) {
            $table->dropForeign('eidolons_ibfk_1');
        });
    }
};
