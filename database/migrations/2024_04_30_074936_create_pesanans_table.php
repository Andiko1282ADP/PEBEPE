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
        Schema::create('pesanans', function (Blueprint $table) {

            
            // $table->foreign('user_id')->references('id')->on('users');
            
            
            // $table->foreign('rute_id')->references('id')->on('rutes');
                        
            $table->id();
            $table->unsignedBiginteger('pembayaran_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rute_id');
            $table->unsignedBigInteger('metode_pembayaran_id');
            $table->string('jumlah_orang');
            $table->date('tanggal_pergi');
            $table->string('status');
            $table->string('kode_booking');
            $table->string('waktu_pesan');
            $table->string('total_tagihan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
