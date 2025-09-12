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
        Schema::create('voyages', function (Blueprint $table) {
            $table->id();
            // Constact all report must have
            $table->foreignId('vessel_id')->constrained()->onDelete('cascade');
            $table->string('voyage_no')->nullable();
            $table->string('report_type');

            // For All Fast
            $table->dateTime('all_fast_datetime')->nullable(); // in local time
            $table->string('port')->nullable();
            $table->string('gmt_offset')->nullable(); // e.g. "+08:00"

            // For Bunkering
            $table->string('bunkering_port')->nullable();
            $table->string('supplier')->nullable();
            $table->dateTime('port_etd')->nullable();
            $table->string('port_gmt_offset')->nullable();
            $table->dateTime('bunker_completed')->nullable();
            $table->string('bunker_gmt_offset')->nullable();

            $table->string('call_sign')->nullable();
            $table->string('flag')->nullable();
            $table->string('port_of_registry')->nullable();
            $table->string('official_number')->nullable();
            $table->string('imo_number')->nullable();
            $table->string('class_society')->nullable();
            $table->string('class_no')->nullable();
            $table->string('pi_club')->nullable();
            $table->string('loa')->nullable();
            $table->string('lbp')->nullable();
            $table->string('breadth_extreme')->nullable();
            $table->string('depth_moulded')->nullable();
            $table->string('height_maximum')->nullable();
            $table->string('bridge_front_bow')->nullable();
            $table->string('bridge_front_stern')->nullable();
            $table->string('light_ship_displacement')->nullable();
            $table->dateTime('keel_laid')->nullable();
            $table->dateTime('launched')->nullable();
            $table->dateTime('delivered')->nullable();
            $table->string('shipyard')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voyages');
    }
};
