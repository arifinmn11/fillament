<?php

namespace App\Models;

use App\Filament\Admin\Resources\SumberDanaResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpnameSumberDana extends Model
{
    use HasFactory;

    protected $table = 'stok_opname_sumber_dana';

    protected $fillable = ['sumber_dana_id', 'tgl_transaksi', 'harga_beli', 'saldo', 'keterangan', 'user_catat_id'];

    public function sumber_dana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }

    public function user_catat()
    {
        return $this->belongsTo(User::class, 'user_catat_id');
    }
}
