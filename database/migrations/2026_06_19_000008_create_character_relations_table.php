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
        Schema::create('character_relations', function (Blueprint $table) {
            $table->id();
            $table->string('character_id');
            $table->string('related_name'); // String instead of strict ID since some names are "Jack Sparrow (uneasy)" or "Royal Navy"
            $table->enum('relation_type', ['ally', 'enemy']);
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_relations');
    }
};
