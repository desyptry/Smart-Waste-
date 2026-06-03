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
        Schema::create('waste_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('drop_off_point_id')->constrained();
            $table->foreignId('waste_category_id')->constrained();
            $table->foreignId('pickup_schedule_id')->nullable()->constrained('pickup_schedules'); // <-- tambah ini
            $table->decimal('weight_kg', 8, 2);
            $table->integer('total_price');
            // $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('deposit_date')->useCurrent();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_deposits');
    }
};
