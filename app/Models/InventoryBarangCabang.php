<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryBarangCabang extends Model
{
    use HasFactory;

    protected $table = 'inventory_barang_cabang';

    protected $fillable = [
        'inventory_barang_id',
        'cabang_id',
        'stok',
        'harga_beli',
        'harga_jual',
        // 'laba',
        // 'is_laba_fleksibel',
    ];

    public function inventory_barang()
    {
        return $this->belongsTo(InventoryBarang::class, 'inventory_barang_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }
}
