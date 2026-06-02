<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom sudah ada sebelum menambahkan
        if (!Schema::hasColumn('waste_deposits', 'pickup_schedule_id')) {
            Schema::table('waste_deposits', function (Blueprint $table) {
                $table->foreignId('pickup_schedule_id')->nullable()->after('verified_by')->constrained('pickup_schedules');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('waste_deposits', 'pickup_schedule_id')) {
            Schema::table('waste_deposits', function (Blueprint $table) {
                $table->dropForeign(['pickup_schedule_id']);
                $table->dropColumn('pickup_schedule_id');
            });
        }
    }
};