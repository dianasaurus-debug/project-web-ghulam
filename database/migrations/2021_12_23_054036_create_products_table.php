<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('kode_barang')->unique();
            $table->string('stok');
            $table->string('harga_beli');
            $table->string('gambar');
            $table->string('qr_code');
            $table->string('harga_jual');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('letak_id')->references('id')->on('letak_barangs')->onDelete('cascade');
            $table->bigInteger('letak_id')->unsigned();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('added_by')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
