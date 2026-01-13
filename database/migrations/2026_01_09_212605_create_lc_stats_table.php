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
        Schema::create('lc_stats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->double('atk')->nullable();
            $table->double('hp')->nullable();
            $table->double('def')->nullable();
            $table->integer('lightcone_id')->nullable()->index('fk_lightcone_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lc_stats');
    }
};
