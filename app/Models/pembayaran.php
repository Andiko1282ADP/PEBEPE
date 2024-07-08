<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;
    protected $table = "pembayarans";
    protected $fillable =
    [
        'nama_transfer',
        'bank_transfer',
        'nomor_rekening',
        'jam_transfer',
        'nominal_transfer',
    ];

    public function pesanan()
    {
        return $this->hasMany(pesanan::class);
    }
}
