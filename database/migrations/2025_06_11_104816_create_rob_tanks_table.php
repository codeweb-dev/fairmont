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
        Schema::create('rob_tanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');
            $table->string('tank_no')->nullable();
            $table->string('description')->nullable();
            $table->string('grade')->nullable();
            $table->string('capacity')->nullable();
            $table->string('unit')->nullable();
            $table->string('rob')->nullable();
            $table->dateTime('supply_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rob_tanks');
    }
};
