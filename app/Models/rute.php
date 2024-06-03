<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rute extends Model
{
    use HasFactory;
    protected $table = "rutes";
    protected $fillable = ['kota_asal', 'kota_tujuan', 'jam_berangkat','jam_tiba' ,'seat','tarif','titik_pemberangkatan'];
    
    
    public function pesanans()
    {
        return $this->hasMany(pesanan::class,'id', 'rutes_id');
    }
}
