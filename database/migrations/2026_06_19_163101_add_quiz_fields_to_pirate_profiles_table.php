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
        Schema::table('pirate_profiles', function (Blueprint $table) {
            $table->string('identity_character')->nullable()->after('pirate_name');
            $table->string('weapon')->nullable()->after('ship');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pirate_profiles', function (Blueprint $table) {
            $table->dropColumn(['identity_character', 'weapon']);
        });
    }
};
