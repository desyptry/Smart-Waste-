<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('pickup_schedules', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('officer_id')->constrained('officer_details')->onDelete('cascade');

            $table->foreignId('collection_point_id')->constrained('drop_off_points')->onDelete('cascade');
            
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->enum('status', ['not-verified', 'verified' , 'declined' ])->default('not-verified');
          $table->string('declined_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_schedules');
    }
};