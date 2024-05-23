<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok_opname_inv_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_barang_cabang_id')->constrained('inventory_barang_cabang');
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->integer('stok');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->timestamp('tgl_transaksi');
            $table->foreignId('user_catat_id')->constrained('users');
            $table->text('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opname_inv_barang');
    }
};
