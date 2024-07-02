<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metode_pembayaran extends Model
{
    use HasFactory;
    protected $table = "metode_pembayarans";
    protected $fillable =
    [
        'jenis_pembayaran',
        'bank',
        'status',
    ];

    public function pesanan()
    {
        return $this->hasMany(pesanan::class);
    }
}
