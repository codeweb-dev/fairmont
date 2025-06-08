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
            $table->foreignId('unit_id')->constrained('users');
            $table->string('report_type');

            // For All Fast
            $table->date('all_fast_datetime')->nullable(); // in local time
            $table->string('port')->nullable();
            $table->string('gmt_offset')->nullable(); // e.g. "+08:00"

            // For Bunkering
            $table->string('bunkering_port')->nullable();
            $table->string('supplier')->nullable();
            $table->date('port_etd')->nullable();
            $table->string('port_gmt_offset')->nullable();
            $table->date('bunker_completed')->nullable();
            $table->string('bunker_gmt_offset')->nullable();

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
