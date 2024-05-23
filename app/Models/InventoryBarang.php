<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryBarang extends Model
{
    use HasFactory;

    protected $table = 'inventory_barang';

    protected $fillable = [
        'kode',
        'nama',
    ];
}
