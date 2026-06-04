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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // warga
            $table->foreignId('asessor_id')->constrained('users'); // petugas penilai
            $table->integer('amount');
            $table->enum('method', ['bank_transfer', 'e_wallet']);
            $table->string('account_name');      // nama bank atau e-wallet
            $table->string('account_number');    // nomor rekening atau HP
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
