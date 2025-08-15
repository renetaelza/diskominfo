<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('nik');
            $table->string('instansi');
            $table->string('jabatan');
            $table->date('tanggal_kunjungan');
            $table->time('pukul_kunjungan');
            $table->text('tujuan');
            $table->foreignId('bidang_id')->constrained('bidang')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('table_kunjungan');
    }
};
