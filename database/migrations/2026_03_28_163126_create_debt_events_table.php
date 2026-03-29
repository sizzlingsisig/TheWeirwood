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
        Schema::create('debt_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->enum('event_type', ['multiplier_1_3', 'multiplier_1_6', 'choice_locked', 'warning_shown', 'game_over']);
            
            $table->smallInteger('debt_value_at_event');
            $table->decimal('multiplier_used', 3, 1)->nullable();
            
            $table->foreignId('triggered_at_node')->nullable()->constrained('nodes')->nullOnDelete();
            $table->timestamp('occurred_at')->useCurrent();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_events');
    }
};
