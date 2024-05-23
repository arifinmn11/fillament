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
        Schema::create('inventory_barang_cabang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_barang_id')->constrained('inventory_barang');
            $table->foreignId('cabang_id')->constrained('cabang');
            $table->unique(['inventory_barang_id', 'cabang_id']); // Ensuring the combination of inventory_barang_id and cabang_id is unique
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);
            // $table->decimal('laba', 12, 2)->default(0);
            // $table->boolean('is_laba_fleksibel')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_barang_cabang');
    }
};
