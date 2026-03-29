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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('house_id')->nullable()->constrained('houses')->nullOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('regions')->nullOnDelete();

            $table->enum('entry_mode', ['map', 'blind']);
            $table->smallInteger('honor')->default(50);
            $table->smallInteger('power')->default(50);
            $table->smallInteger('debt')->default(20);

            $table->foreignId('current_node_id')->constrained('nodes');
            $table->boolean('is_complete')->default(false);

            $table->timestamp('session_started')->useCurrent();
            $table->timestamp('session_ended')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
