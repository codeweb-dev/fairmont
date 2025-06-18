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
        Schema::create('board_crews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            $table->string('no')->nullable();
            $table->string('vessel_name')->nullable();
            $table->string('crew_surname')->nullable();
            $table->string('crew_first_name')->nullable();
            $table->string('rank')->nullable();
            $table->string('crew_nationality')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('contract_completion')->nullable();
            $table->string('current_date')->nullable();
            $table->string('days_contract_completion')->nullable();
            $table->string('months_on_board')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_crews');
    }
};
