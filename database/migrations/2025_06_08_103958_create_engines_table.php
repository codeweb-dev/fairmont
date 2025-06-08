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
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->onDelete('cascade');
            $table->decimal('avg_me_rpm', 10, 3)->nullable();
            $table->decimal('avg_me_kw', 10, 3)->nullable();
            $table->decimal('tdr', 10, 3)->nullable();
            $table->decimal('tst', 10, 3)->nullable();
            $table->decimal('slip', 10, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
