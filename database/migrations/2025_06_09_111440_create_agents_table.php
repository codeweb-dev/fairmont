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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('port_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();       // Agent's Name
            $table->string('address')->nullable();    // Address
            $table->string('pic_name')->nullable();   // PIC Name
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
