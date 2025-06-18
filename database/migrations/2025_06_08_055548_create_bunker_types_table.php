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
        Schema::create('bunker_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            $table->decimal('hsfo_quantity', 10, 3)->nullable();
            $table->string('hsfo_viscosity')->nullable();

            $table->decimal('biofuel_quantity', 10, 3)->nullable();
            $table->string('biofuel_viscosity')->nullable();

            $table->decimal('vlsfo_quantity', 10, 3)->nullable();
            $table->string('vlsfo_viscosity')->nullable();

            $table->decimal('lsmgo_quantity', 10, 3)->nullable();
            $table->string('lsmgo_viscosity')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bunker_types');
    }
};
