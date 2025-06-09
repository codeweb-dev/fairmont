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
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');
            $table->string('port')->nullable();
            $table->string('activity')->nullable(); // e.g. Loading, Unloading
            $table->dateTime('eta_etb')->nullable();
            $table->dateTime('etcd')->nullable();
            $table->string('cargo')->nullable(); // e.g. Oil
            $table->string('cargo_qty')->nullable(); // Quantity of cargo
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
