<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('featured_character_id')->nullable()->after('id');
            $table->integer('featured_lightcone_id')->nullable()->after('featured_character_id');

            $table->foreign('featured_character_id')
                ->references('id')
                ->on('characters')
                ->nullOnDelete();

            $table->foreign('featured_lightcone_id')
                ->references('id')
                ->on('lightcones')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['featured_character_id']);
            $table->dropForeign(['featured_lightcone_id']);

            $table->dropColumn([
                'featured_character_id',
                'featured_lightcone_id',
            ]);
        });
    }
};