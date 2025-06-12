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
        Schema::create('weather_observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            $table->string('time_block')->nullable();
            $table->string('wind_force')->nullable();
            $table->string('wind_direction')->nullable();
            $table->string('swell_height')->nullable();
            $table->string('swell_direction')->nullable();
            $table->string('wind_sea_height')->nullable();
            $table->string('sea_direction')->nullable();
            $table->string('sea_ds')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_observations');
    }
};
