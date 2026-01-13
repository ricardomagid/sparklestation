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
        Schema::create('relic_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('slug', 50)->unique('code');
            $table->decimal('main_stat_value', 8, 4)->nullable();
            $table->decimal('main_level_increase', 8, 4)->nullable();
            $table->boolean('main_possible')->nullable()->default(false);
            $table->boolean('sub_possible')->nullable()->default(false);
            $table->decimal('sub_low', 10, 6)->nullable();
            $table->decimal('sub_med', 10, 6)->nullable();
            $table->decimal('sub_high', 10, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relic_stats');
    }
};
