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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk', 100)->nullable()->default('text');
            $table->text('deskripsi')->nullable()->default('text');
            $table->integer('harga')->unsigned()->nullable()->default(11);
            $table->integer('stok')->unsigned()->nullable()->default(11);
            $table->string('kategori', 50)->nullable()->default('text');
            $table->string('gambar_produk', 255)->nullable()->default('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
