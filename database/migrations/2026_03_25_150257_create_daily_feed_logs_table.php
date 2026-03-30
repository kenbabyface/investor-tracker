<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_feed_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pond_id')->constrained('ponds')->onDelete('cascade');
            $table->foreignId('feed_size_id')->constrained('feed_sizes')->onDelete('cascade');
            $table->date('log_date');
            $table->decimal('quantity_kg', 8, 2);         // how many kg fed
            $table->decimal('price_per_kg', 10, 2);       // snapshot of price at time of logging
            $table->decimal('total_cost', 10, 2);         // quantity_kg * price_per_kg
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_feed_logs');
    }
};