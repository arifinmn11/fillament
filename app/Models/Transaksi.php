<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = [
        'tgl_transaksi',
        'no_transaksi',
        'keterangan',
        'is_sumber_dana',
        'sumber_dana_id',
        'inv_barang_cabang_id',
        'cabang_id',
        'kategori_pembayaran_id',
        'user_id',
        'harga_beli',
        'harga_jual',
        'qty',
        'total_harga',

    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }

    public function invBarangCabang()
    {
        return $this->belongsTo(InventoryBarangCabang::class, 'inv_barang_cabang_id');
    }

    public function kategoriPembayaran()
    {
        return $this->belongsTo(KategoriPembayaran::class, 'kategori_pembayaran_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
