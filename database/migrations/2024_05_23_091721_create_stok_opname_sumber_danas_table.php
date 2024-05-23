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
        Schema::create('stok_opname_sumber_dana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_dana_id')->constrained('sumber_dana');
            $table->decimal('harga_beli', 12, 2);
            $table->decimal('saldo', 12, 2);
            $table->string('keterangan');
            $table->foreignId('user_catat_id')->constrained('users');
            $table->timestamp('tgl_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opname_sumber_dana');
    }
};
