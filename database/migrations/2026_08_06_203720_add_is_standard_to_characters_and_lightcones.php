<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->boolean('is_standard')
                ->default(false);
        });

        Schema::table('lightcones', function (Blueprint $table) {
            $table->boolean('is_standard')
                ->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('is_standard');
        });

        Schema::table('lightcones', function (Blueprint $table) {
            $table->dropColumn('is_standard');
        });
    }
};