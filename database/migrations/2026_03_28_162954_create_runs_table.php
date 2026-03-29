<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->unique()->constrained('games')->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('starting_node_id')->nullable()->constrained('nodes')->nullOnDelete();
            $table->foreignId('ending_node_id')->constrained('nodes');

            $table->smallInteger('final_honor');
            $table->smallInteger('final_power');
            $table->smallInteger('final_debt');
            $table->integer('steps_taken')->default(0);
            $table->boolean('is_victory')->default(false);
            $table->foreignId('unlocked_house_id')->nullable()->constrained('houses')->nullOnDelete();

            $table->timestamp('completed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('runs');
    }
};
