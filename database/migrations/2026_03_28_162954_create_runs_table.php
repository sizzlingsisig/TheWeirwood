<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->unique()->constrained('games')->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('ending_node_id')->constrained('nodes');
            
            $table->string('verdict_label', 80);
            $table->string('ending_type', 20);
            $table->foreignId('house_unlocked_id')->nullable()->constrained('houses')->nullOnDelete();
            
            $table->smallInteger('final_honor');
            $table->smallInteger('final_power');
            $table->smallInteger('final_debt');
            $table->integer('duration_seconds')->nullable();
            
            $table->timestamp('completed_at')->useCurrent();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runs');
    }
};
