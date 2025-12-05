<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained()->onDelete('cascade');
            $table->decimal('investment_amount', 15, 2);
            $table->date('investment_date');
            $table->enum('investment_type', ['single_cycle', 'double_cycle']);
            $table->integer('cycle_number')->default(1);
            $table->date('roi_date');
            $table->decimal('roi_amount', 15, 2);
            $table->enum('roi_status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};