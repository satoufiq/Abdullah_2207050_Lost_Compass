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
        Schema::create('mission_scenes', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. 'aztec-coin-start'
            $table->foreignId('mission_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('scene_text');
            $table->string('image')->nullable();
            $table->boolean('is_ending')->default(false);
            $table->string('outcome_type')->nullable(); // 'success', 'failure'
            $table->json('rewards')->nullable(); // JSON structure for gold, reputation, relics
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_scenes');
    }
};
