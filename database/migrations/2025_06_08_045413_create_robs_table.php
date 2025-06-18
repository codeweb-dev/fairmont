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
        Schema::create('robs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            // Fuel types — nullable since each row might not have all fields filled
            $table->decimal('hsfo', 10, 3)->nullable();
            $table->decimal('biofuel', 10, 3)->nullable();
            $table->decimal('vlsfo', 10, 3)->nullable();
            $table->decimal('lsmgo', 10, 3)->nullable();

            // For Voyage Report
            $table->decimal('me_cc_oil', 10, 3)->nullable();
            $table->decimal('mc_cyl_oil', 10, 3)->nullable();
            $table->decimal('ge_cc_oil', 10, 3)->nullable();
            $table->decimal('fw', 10, 3)->nullable();
            $table->decimal('fw_produced', 10, 3)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('robs');
    }
};
