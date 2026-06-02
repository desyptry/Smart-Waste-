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
        Schema::create('schedule_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('waste_category_id')->constrained();
            $table->integer('price_per_kg');          // harga khusus untuk jadwal ini
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_prices');
    }
};
