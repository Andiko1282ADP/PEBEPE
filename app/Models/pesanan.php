<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    use HasFactory;
    protected $table = "pesanans";
    protected $fillable =
    [
        'jumlah_orang',
        'tanggal_pergi',
        'status',
        'kode_booking',
        'waktu_pesan',
        'total_tagihan',
        'user_id',
        'metode_pembayaran_id',
        'rute_id',
        'pembayaran_id',
    ];

    // Belongs To
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function metode_pembayarans()
    {
        return $this->belongsTo(metode_pembayaran::class, 'metode_pembayaran_id','id');
    }
    public function rutes()
    {
        return $this->belongsTo(rute::class, 'rute_id', 'id');
    }
    public function pembayarans()
    {
        return $this->belongsTo(rute::class, 'pembayaran_id', 'id');
    }

    // Has Many
    // public function pembatalans()
    // {
    //     return $this->hasMany(pembatalan::class, 'id', 'pesanans_id','id');
    // }
}
