<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->enum('status', ['Menunggu', 'Terkirim'])->default('Menunggu');
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Dibayar'])->default('Belum Dibayar');
            $table->enum('tipe_pembayaran', ['Cash', 'Online'])->default('Online');
            $table->integer('jumlah')->default(1);
            $table->string('total_bayar');
            $table->double('ongkir');
            $table->text('pesan');
            $table->string('snap_token')->nullable();
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
        Schema::dropIfExists('acc_penjualans');
    }
}
