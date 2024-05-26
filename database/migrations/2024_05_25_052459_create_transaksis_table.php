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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tgl_transaksi');
            $table->string('no_transaksi')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('cabang_id')->constrained('cabang');
            $table->foreignId('sumber_dana_id')->nullable()->constrained('sumber_dana');
            $table->foreignId('inv_barang_cabang_id')->nullable()->constrained('inventory_barang_cabang');
            $table->string('keterangan')->nullable();
            $table->boolean('is_sumber_dana')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
