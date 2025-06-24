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
        Schema::create('crew_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');

            $table->string('vessel_name')->nullable();
            $table->string('port')->nullable();
            $table->string('country')->nullable();
            $table->dateTime('joiners_boarding')->nullable();
            $table->dateTime('off_signers')->nullable();
            $table->string('joiner_ranks')->nullable();
            $table->string('off_signers_ranks')->nullable();
            $table->string('total_crew_change')->nullable();
            $table->string('reason_change')->nullable();
            $table->string('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crew_changes');
    }
};
