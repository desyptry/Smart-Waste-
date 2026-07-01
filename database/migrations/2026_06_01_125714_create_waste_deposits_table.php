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
            $table->foreignId('user_id')->constrained("users");
            $table->foreignId('drop_off_point_id')->constrained("drop_off_points")->onDelete('cascade');
            $table->foreignId('pickup_schedule_id')->nullable()->constrained('pickup_schedules'); // <-- tambah ini
            $table->foreignId('officer_id')->nullable()->constrained('users');
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
