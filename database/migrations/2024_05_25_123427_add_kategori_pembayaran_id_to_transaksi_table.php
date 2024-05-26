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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreignId('kategori_pembayaran_id')->nullable()->constrained('kategori_pembayaran');
            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);
            $table->integer('qty')->default(1);
            $table->decimal('total_harga', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['kategori_pembayaran_id']);
            $table->dropColumn('kategori_pembayaran_id');
            $table->dropColumn('harga_beli');
            $table->dropColumn('harga_jual');
            $table->dropColumn('qty');
            $table->dropColumn('total_harga');
        });
    }
};
