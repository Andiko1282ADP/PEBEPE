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
        'image'
    ];

    public function pesanan()
    {
        return $this->hasMany(pesanan::class);
    }
}
