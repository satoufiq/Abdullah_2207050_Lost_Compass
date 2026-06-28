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
        Schema::table('ships', function (Blueprint $table) {
            $table->foreignId('captain_id')->nullable()->constrained('captains')->nullOnDelete();
            $table->string('type')->nullable(); // e.g., Ghost Ship, Navy Ship
            $table->integer('speed')->default(0);
            $table->integer('attack_power')->default(0);
            $table->integer('defense')->default(0);
            $table->integer('curse_level')->default(0);
            $table->string('weapons')->nullable();
            $table->text('history')->nullable(); // For long lore / description. Note: 'description' already exists in older migration.
            $table->string('fate')->nullable();
            $table->string('curse')->nullable(); // Text description of curse
            $table->string('short_power')->nullable();
            $table->string('tags')->nullable(); // CSV or JSON for filtering tags
            $table->integer('legend_rank')->default(0);
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->foreignId('ship_id')->nullable()->constrained('ships')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropForeign(['ship_id']);
            $table->dropColumn('ship_id');
        });

        Schema::table('ships', function (Blueprint $table) {
            $table->dropForeign(['captain_id']);
            $table->dropColumn([
                'captain_id', 'type', 'speed', 'attack_power', 'defense', 
                'curse_level', 'weapons', 'history', 'fate', 'curse', 'short_power', 'tags', 'legend_rank'
            ]);
        });
    }
};
