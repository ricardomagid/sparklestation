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
        Schema::table('materials', function (Blueprint $table) {
            $table->foreign(['element_id'], 'materials_ibfk_1')->references(['id'])->on('elements')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['path_id'], 'materials_ibfk_2')->references(['id'])->on('paths')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['type_id'], 'materials_ibfk_3')->references(['id'])->on('material_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign('materials_ibfk_1');
            $table->dropForeign('materials_ibfk_2');
            $table->dropForeign('materials_ibfk_3');
        });
    }
};
