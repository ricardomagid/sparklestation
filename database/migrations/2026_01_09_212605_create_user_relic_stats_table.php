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
        Schema::create('user_relic_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_relic_id')->index('idx_user_relic');
            $table->unsignedBigInteger('stat_id')->index('idx_stat');
            $table->float('value');
            $table->integer('rolls')->nullable()->default(0);
            $table->boolean('is_main')->nullable()->default(false);
            $table->unsignedTinyInteger('line_order')->nullable();
            $table->boolean('is_hidden')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_relic_stats');
    }
};
