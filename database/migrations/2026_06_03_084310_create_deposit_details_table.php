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
        Schema::create('deposit_details', function (Blueprint $table) {
          $table->foreignId('waste_deposit_id')->constrained('waste_deposits')->onDelete('cascade');
          $table->foreignId('waste_price_id')->constrained('schedule_prices')->onDelete('cascade');
            $table->decimal('weight_kg', 8, 2);
            $table->integer('total_price');
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_details');
    }
};
