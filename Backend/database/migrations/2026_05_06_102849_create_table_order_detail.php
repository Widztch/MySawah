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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_order')->nullable();
            $table->foreign('id_order')->references('id_orders')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->integer('jumlah')->unsigned()->nullable()->default(11);
            $table->integer('harga_saat_beli')->unsigned()->nullable()->default(11);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
