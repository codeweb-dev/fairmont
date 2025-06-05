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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->morphs('auditable'); // to track the related model (id + type)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // user who performed the action
            $table->string('event'); // e.g. created, updated, deleted
            $table->json('old_values')->nullable(); // before change
            $table->json('new_values')->nullable(); // after change
            $table->string('ip_address')->nullable(); // IP address
            $table->string('user_agent')->nullable(); // browser, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
