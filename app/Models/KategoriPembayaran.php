<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembayaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pembayaran';

    protected $fillable = [
        'kode',
        'nama',
        'is_harga_flexible',
        'harga_beli',
        'harga_jual',
        'laba',
    ];

    protected $casts = [
        'is_laba_fleksibel' => 'boolean',
    ];
}
