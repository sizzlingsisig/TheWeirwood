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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('icon_image_path')->nullable();
            
            // restrictOnDelete prevents deleting a house if regions still belong to it
            $table->foreignId('house_id')->constrained('houses')->restrictOnDelete(); 
            
            $table->smallInteger('starting_honor');
            $table->smallInteger('starting_power');
            $table->smallInteger('starting_debt');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
