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
        Schema::table('questions', function (Blueprint $table) {
            $table->string('type')->default('identity')->after('id');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->string('ship_impact')->nullable()->after('allegiance_impact');
            $table->string('weapon_impact')->nullable()->after('ship_impact');
            $table->string('role_impact')->nullable()->change();
            $table->string('trait_impact')->nullable()->change();
            $table->string('allegiance_impact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn(['ship_impact', 'weapon_impact']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
