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
        Schema::create('waste_price_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_category_id')->constrained()->onDelete('cascade');
            $table->date('date'); // tanggal berlakunya harga
            $table->integer('price_per_kg'); // harga dalam rupiah
            $table->time('pickup_start_time')->nullable(); // opsional: jam mulai pengumpulan
            $table->time('pickup_end_time')->nullable();   // opsional: jam selesai
            $table->text('location')->nullable(); // lokasi pengumpulan (misal: Balai Br. Ambengan)
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_price_schedules');
    }
};
