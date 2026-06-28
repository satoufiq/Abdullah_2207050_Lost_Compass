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
        Schema::table('users', function (Blueprint $table) {
            $table->string('pirate_name')->nullable();
            $table->string('identity_character')->nullable();
            $table->string('ship')->nullable();
            $table->string('weapon')->nullable();
            $table->string('relic')->nullable();
            $table->string('allegiance')->nullable();
            $table->string('rank')->default('Deckhand');
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'pirate_name',
                'identity_character',
                'ship',
                'weapon',
                'relic',
                'allegiance',
                'rank',
                'avatar',
            ]);
        });
    }
};
