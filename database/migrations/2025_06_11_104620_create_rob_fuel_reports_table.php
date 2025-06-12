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
        Schema::create('rob_fuel_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');
            $table->string('fuel_type'); // HSFO, BIOFUEL, etc.

            // ROB Summary
            $table->string('previous')->nullable();
            $table->string('current')->nullable();
            $table->string('me_propulsion')->nullable();
            $table->string('ae_cons')->nullable();
            $table->string('boiler_cons')->nullable();
            $table->string('incinerators')->nullable();
            $table->string('me_24')->nullable();
            $table->string('ae_24')->nullable();
            $table->string('total_cons')->nullable();

            // Lube Oils: ME CYL
            $table->string('me_cyl_grade')->nullable();
            $table->string('me_cyl_qty')->nullable();
            $table->string('me_cyl_hrs')->nullable();
            $table->string('me_cyl_cons')->nullable();

            // Lube Oils: ME CC
            $table->string('me_cc_qty')->nullable();
            $table->string('me_cc_hrs')->nullable();
            $table->string('me_cc_cons')->nullable();

            // Lube Oils: AE CC
            $table->string('ae_cc_qty')->nullable();
            $table->string('ae_cc_hrs')->nullable();
            $table->string('ae_cc_cons')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rob_fuel_reports');
    }
};
