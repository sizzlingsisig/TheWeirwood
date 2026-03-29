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
        Schema::create('game_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('choice_id')->constrained('choices')->cascadeOnDelete();
            
            $table->smallInteger('sequence_order');
            $table->smallInteger('honor_before');
            $table->smallInteger('power_before');
            $table->smallInteger('debt_before');
            $table->smallInteger('honor_after');
            $table->smallInteger('power_after');
            $table->smallInteger('debt_after');
            
            $table->decimal('debt_multiplier_applied', 3, 1)->default(1.0);
            $table->timestamp('chosen_at')->useCurrent();
            
            $table->unique(['game_id', 'sequence_order']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_steps');
    }
};
