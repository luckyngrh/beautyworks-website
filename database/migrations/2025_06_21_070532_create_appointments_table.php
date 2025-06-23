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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('id_appointment');
            $table->string('nama')->nullable();
            $table->string('kontak')->nullable();
            $table->string('nama_mua')->nullable();
            $table->string('jenis_layanan', 15);
            $table->date('tanggal_appointment');
            $table->time('waktu_appointment');
            $table->string('status', 20)->default('Menunggu Konfirmasi')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
