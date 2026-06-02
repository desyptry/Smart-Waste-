<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pickup_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drop_off_point_id')->constrained();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['akan_datang', 'sedang_berlangsung', 'selesai'])->default('akan_datang');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pickup_schedules');
    }
};