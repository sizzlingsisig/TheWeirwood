<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->string('flag_key');
            $table->boolean('value')->default(true);
            $table->timestamps();

            $table->unique(['game_id', 'flag_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_flags');
    }
};
