<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokOpnameInventoryBarangCabang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stok_opname_inv_barang';

    protected $fillable = [
        'inv_barang_cabang_id',
        'harga_beli',
        'stok',
        'total_harga',
        'tgl_transaksi',
        'user_catat_id',
        'keterangan',
    ];

    public function inventory_barang_cabang()
    {
        return $this->belongsTo(InventoryBarangCabang::class, 'inv_barang_cabang_id');
    }

    public function user_catat()
    {
        return $this->belongsTo(User::class, 'user_catat_id');
    }

}
