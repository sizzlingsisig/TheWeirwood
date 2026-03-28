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
        Schema::create('endings', function (Blueprint $table) {
            // In Laravel, making a foreign key the primary key is handled this way:
            $table->foreignId('node_id')->primary()->constrained('nodes')->cascadeOnDelete();
            
            $table->string('verdict_label', 80);
            $table->enum('ending_type', ['honor', 'power', 'debt', 'war', 'neutral']);
            $table->text('ending_text');
            
            $table->foreignId('required_house_id')->nullable()->constrained('houses')->nullOnDelete();
            $table->foreignId('unlocks_house_id')->nullable()->constrained('houses')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endings');
    }
};
