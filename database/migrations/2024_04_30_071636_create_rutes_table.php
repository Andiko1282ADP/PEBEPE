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
        Schema::create('rutes', function (Blueprint $table) {

            // $table->unsignedBigInteger('user_id');
 
            // $table->foreign('user_id')->references('id')->on('users');

            $table->id();
            $table->string('kota_asal');
            $table->string('kota_tujuan');
            $table->string('jam_berangkat');
            $table->string('jam_tiba');
            $table->string('seat');
            $table->string('tarif');
            $table->string('titik_pemberangkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
