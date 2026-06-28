<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('rarity')->default('common'); // common, rare, epic, legendary
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relics');
    }
};
