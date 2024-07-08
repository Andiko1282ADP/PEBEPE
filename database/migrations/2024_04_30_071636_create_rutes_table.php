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
            $table->string('kota_asal',15);
            $table->string('kota_tujuan',15);
            $table->string('jam_berangkat');
            $table->string('jam_tiba');
            $table->string('tarif',20);
            $table->string('titik_pemberangkatan',20);
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
