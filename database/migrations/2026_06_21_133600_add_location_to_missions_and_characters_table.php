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
        Schema::table('missions', function (Blueprint $table) {
            $table->string('location_id')->nullable()->after('location');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->string('primary_location_id')->nullable()->after('ship_name');
            $table->foreign('primary_location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign(['primary_location_id']);
            $table->dropColumn('primary_location_id');
        });
    }
};
