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
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            // Waste Management
            $table->string('plastics_landed_ashore')->nullable();
            $table->string('plastics_incinerated')->nullable();
            $table->string('food_disposed_sea')->nullable();
            $table->string('food_landed_ashore')->nullable();
            $table->string('domestic_landed_ashore')->nullable();
            $table->string('domestic_incinerated')->nullable();
            $table->string('cooking_oil_landed_ashore')->nullable();
            $table->string('cooking_oil_incinerated')->nullable();
            $table->string('incinerator_ash_landed_ashore')->nullable();
            $table->string('incinerator_ash_incinerated')->nullable();
            $table->string('operational_landed_ashore')->nullable();
            $table->string('operational_incinerated')->nullable();
            $table->string('ewaste_landed_ashore')->nullable();

            // Cargo & Garbage
            $table->string('cargo_residues_landed_ashore')->nullable();
            $table->string('total_garbage_disposed_sea')->nullable();
            $table->string('total_garbage_landed_ashore')->nullable();

            // Sludge & Bunker
            $table->string('sludge_landed_ashore')->nullable();
            $table->string('sludge_incinerated')->nullable();
            $table->string('sludge_generated')->nullable();
            $table->string('fuel_consumed')->nullable();
            $table->string('sludge_bunker_ratio')->nullable();
            $table->text('sludge_remarks')->nullable();

            // Bilge Water
            $table->string('bilge_discharged_ows')->nullable();
            $table->string('bilge_landed_ashore')->nullable();
            $table->string('bilge_generated')->nullable();

            // Consumption
            $table->string('paper_consumption')->nullable();
            $table->string('printer_cartridges')->nullable();
            $table->text('consumption_remarks')->nullable();

            // Fresh Water
            $table->string('fresh_water_generated')->nullable();
            $table->string('fresh_water_consumed')->nullable();

            // Ballast Water
            $table->string('ballast_exchanges')->nullable();
            $table->string('ballast_operations')->nullable();
            $table->string('deballast_operations')->nullable();
            $table->string('ballast_intake')->nullable();
            $table->string('ballast_out')->nullable();
            $table->string('ballast_exchange_amount')->nullable();

            // Cleaning
            $table->string('propeller_cleanings')->nullable();
            $table->string('hull_cleanings')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
