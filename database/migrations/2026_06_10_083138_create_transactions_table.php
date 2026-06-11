<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            
            // Tambahkan baris relasi ini untuk mencatat transaksi dilakukan oleh siapa
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('set null');
            
            $table->integer('total_price');
            $table->integer('total_accepted');
            $table->integer('total_return');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};