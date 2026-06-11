<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Tambahkan employee_id ke dalam baris aman (fillable)
    protected $fillable = ['invoice_number', 'employee_id', 'total_price', 'total_accepted', 'total_return'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Hubungan: Transaksi ini dilayani oleh karyawan siapa
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}