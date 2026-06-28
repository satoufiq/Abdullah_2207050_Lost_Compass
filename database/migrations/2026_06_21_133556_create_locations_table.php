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
        Schema::create('locations', function (Blueprint $table) {
            $table->string('id')->primary(); // String ID like 'tortuga'
            $table->string('name');
            $table->string('type');
            $table->text('description');
            $table->string('danger_level');
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_label')->nullable();
            $table->float('x_position');
            $table->float('y_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
