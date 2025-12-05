<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained()->onDelete('cascade');
            $table->decimal('investment_amount', 15, 2);
            $table->date('investment_date');
            $table->date('roi_date');
            $table->decimal('roi_amount', 15, 2);
            $table->date('payment_date');
            $table->string('cycle_completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_history');
    }
};