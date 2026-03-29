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
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            
            // DAG Edges
            $table->foreignId('from_node_id')->constrained('nodes')->cascadeOnDelete();
            $table->foreignId('to_node_id')->constrained('nodes')->cascadeOnDelete();
            
            $table->smallInteger('display_order')->default(0);
            $table->foreignId('required_house_id')->nullable()->constrained('houses')->nullOnDelete();
            
            $table->text('choice_text');
            $table->string('hint_text', 255)->nullable();
            $table->smallInteger('honor_delta')->default(0);
            $table->smallInteger('power_delta')->default(0);
            $table->smallInteger('debt_delta')->default(0);
            $table->boolean('locks_on_high_debt')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Ensures you don't accidentally assign the same display order twice on one node
            $table->unique(['from_node_id', 'display_order']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
