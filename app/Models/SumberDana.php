<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SumberDana extends Model
{
    use HasFactory;
    protected $table = 'sumber_dana';
    protected $fillable = ['kode', 'nama', 'no', 'cabang_id', 'saldo'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }
}
