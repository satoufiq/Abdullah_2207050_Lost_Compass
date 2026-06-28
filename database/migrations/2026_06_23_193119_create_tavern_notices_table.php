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
        Schema::create('tavern_notices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reward');
            $table->text('desc');
            $table->string('image')->default('wanted-default.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tavern_notices');
    }
};
