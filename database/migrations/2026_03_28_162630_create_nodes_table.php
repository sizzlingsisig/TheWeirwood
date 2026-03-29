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
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->string('node_code', 40)->unique(); // e.g., 'node_001'
            $table->string('chapter_label', 120)->nullable();
            $table->string('title', 120);
            $table->string('art_image_path')->nullable();
            $table->text('narrative_text');
            $table->text('debt_warning_text')->nullable();
            $table->smallInteger('debt_warning_threshold')->default(40);
            $table->boolean('is_ending')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
