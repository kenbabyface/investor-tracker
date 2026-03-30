<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // e.g. "2mm Starter", "4mm Grower"
            $table->string('size')->nullable(); // e.g. "2mm", "4mm"
            $table->decimal('price_per_kg', 10, 2); // price per kg in your currency
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_sizes');
    }
};