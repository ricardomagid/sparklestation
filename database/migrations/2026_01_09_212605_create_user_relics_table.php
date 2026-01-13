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
        Schema::create('user_relics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('idx_user');
            $table->unsignedBigInteger('piece_id')->index('idx_piece');
            $table->enum('item_type', ['relic', 'planarOrnament']);
            $table->unsignedTinyInteger('level')->nullable()->default(0);
            $table->enum('status', ['none', 'locked', 'discarded'])->nullable()->default('none');
            $table->timestamp('obtained_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_relics');
    }
};
