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
        Schema::create('associated_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            $table->string('port_delivery')->nullable();
            $table->date('eosp')->nullable();

            $table->string('eosp_gmt')->nullable();
            $table->date('barge')->nullable();

            $table->string('barge_gmt')->nullable();
            $table->date('cosp')->nullable();

            $table->string('cosp_gmt')->nullable();
            $table->date('anchor')->nullable();

            $table->string('anchor_gmt')->nullable();
            $table->date('pumping')->nullable();

            $table->string('pumping_gmt')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associated_information');
    }
};
