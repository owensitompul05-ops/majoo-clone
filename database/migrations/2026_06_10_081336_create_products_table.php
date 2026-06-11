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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique(); // Kode unik produk / barcode
            $table->string('name');          // Nama produk
            $table->integer('price_buy');    // Harga beli (HPP)
            $table->integer('price_sell');   // Harga jual ke pelanggan
            $table->integer('stock');        // Jumlah stok barang
            $table->timestamps();            // Otomatis mencatat waktu dibuat & diedit
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};