<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Baris ini wajib ada untuk memberi tahu Laravel kolom apa saja yang boleh diisi
    protected $fillable = ['sku', 'name', 'price_buy', 'price_sell', 'stock'];
}