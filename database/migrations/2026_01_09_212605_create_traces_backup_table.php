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
        Schema::create('traces_backup', function (Blueprint $table) {
            $table->integer('id')->default(0);
            $table->string('name')->nullable();
            $table->string('description', 500)->nullable();
            $table->integer('position')->nullable();
            $table->integer('character_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traces_backup');
    }
};
