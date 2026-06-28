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
        Schema::create('mission_choices', function (Blueprint $table) {
            $table->id();
            $table->string('scene_id');
            $table->foreign('scene_id')->references('id')->on('mission_scenes')->onDelete('cascade');
            $table->string('choice_text');
            $table->string('consequence_text')->nullable();
            $table->string('next_scene_id');
            $table->string('sfx')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_choices');
    }
};
