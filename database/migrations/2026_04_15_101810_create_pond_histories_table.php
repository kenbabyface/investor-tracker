<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('pond_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pond_id')->constrained()->onDelete('cascade');
            $table->string('pond_name');
            $table->string('species')->nullable();
            $table->integer('stock_count')->default(0);
            $table->timestamp('stocked_at')->nullable();
            $table->decimal('total_feed_bags', 10, 2)->default(0);
            $table->decimal('total_feed_kg', 10, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->timestamp('archived_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pond_histories');
    }
};
