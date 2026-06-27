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
        Schema::create('characters', function (Blueprint $table) {
            $table->string('id')->primary(); // Using string IDs like 'jack-sparrow' from the JS
            $table->string('name');
            $table->string('role');
            $table->string('short_line');
            $table->string('quote')->nullable();
            $table->string('category'); // e.g. captains, allies, villains, legends
            $table->json('tags')->nullable(); // JSON array for extra tags
            $table->string('image')->nullable();
            $table->text('biography');
            $table->string('weapon')->nullable();
            $table->string('first_appearance')->nullable();
            
            // Allow string ship names directly or foreign keys
            $table->string('ship_name')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
