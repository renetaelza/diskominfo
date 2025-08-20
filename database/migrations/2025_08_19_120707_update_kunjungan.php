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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();

            // Data Pemohon
            $table->string('nama');
            $table->string('nama_instansi');
            $table->string('nomor_hp'); 
            $table->string('email');
            $table->string('kab_kota');
            $table->text('alamat_instansi'); 

            // Data Tujuan Reservasi
            $table->date('tanggal_kunjungan');
            $table->time('pukul_kunjungan');
            $table->text('topik_diskusi');
            $table->integer('jumlah_rombongan');

            // Data Surat Permohonan
            $table->string('no_surat'); 
            $table->date('tanggal_surat'); 
            $table->string('surat_permohonan');

            // Status
            $table->string('status')->default('pending'); // pending, approved, rejected

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Corrected table name for dropping
        Schema::dropIfExists('kunjungan');
    }
};