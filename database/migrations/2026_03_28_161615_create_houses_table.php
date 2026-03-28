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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('motto', 80)->nullable();
            $table->text('description')->nullable();
            $table->string('sigil_image_path')->nullable();
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
        Schema::dropIfExists('houses');
    }
};
