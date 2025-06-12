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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            $table->string('cp_ordered_speed')->nullable();
            $table->string('me_cons_cp_speed')->nullable();
            $table->string('obs_distance')->nullable();
            $table->string('steaming_time')->nullable();
            $table->string('avg_speed')->nullable();
            $table->string('distance_to_go')->nullable();
            $table->string('course')->nullable();
            $table->string('breakdown')->nullable();
            $table->string('avg_rpm')->nullable();
            $table->string('engine_distance')->nullable();
            $table->string('me_output_mcr')->nullable();
            $table->string('avg_power')->nullable();
            $table->string('logged_distance')->nullable();
            $table->string('speed_through_water')->nullable();
            $table->string('next_port')->nullable();
            $table->date('eta_next_port')->nullable();
            $table->string('eta_gmt_offset')->nullable();
            $table->string('anchored_hours')->nullable();
            $table->string('drifting_hours')->nullable();
            $table->string('maneuvering_hours')->nullable();

            // Noon Condition
            $table->string('condition')->nullable();
            $table->string('displacement')->nullable();
            $table->string('cargo_name')->nullable();
            $table->string('cargo_weight')->nullable();
            $table->string('ballast_weight')->nullable();
            $table->string('fresh_water')->nullable();
            $table->string('fwd_draft')->nullable();
            $table->string('aft_draft')->nullable();
            $table->string('gm')->nullable();

            // Voyage Itinerary
            $table->string('next_port_voyage')->nullable();
            $table->string('via')->nullable();
            $table->date('eta_lt')->nullable();
            $table->string('gmt_offset_voyage')->nullable();
            $table->string('distance_to_go_voyage')->nullable();
            $table->string('projected_speed')->nullable();

            // Average Weather
            $table->string('wind_force_average_weather')->nullable();
            $table->string('swell')->nullable();
            $table->string('sea_current')->nullable();
            $table->string('sea_temp')->nullable();
            $table->string('observed_wind')->nullable();
            $table->string('wind_sea_height')->nullable();
            $table->string('sea_current_direction')->nullable();
            $table->string('swell_height')->nullable();
            $table->string('observed_sea')->nullable();
            $table->string('air_temp')->nullable();
            $table->string('observed_swell')->nullable();
            $table->string('sea_ds')->nullable();
            $table->string('atm_pressure')->nullable();

            // Bad Weather
            $table->string('wind_force_previous')->nullable();
            $table->string('wind_force_current')->nullable();
            $table->string('sea_state_previous')->nullable();
            $table->string('sea_state_current')->nullable();

            // Diesel Engine
            $table->string('dg1_run_hours')->nullable();
            $table->string('dg2_run_hours')->nullable();
            $table->string('dg3_run_hours')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
