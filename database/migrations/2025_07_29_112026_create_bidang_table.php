<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bidang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        DB::table('bidang')->insert([
            ['nama' => 'Semua Bidang'],
            ['nama' => 'Kepala Dinas'],
            ['nama' => 'Sektretariat'],
            ['nama' => 'Bidang Perencanaan, Evaluasi dan Pengembangan Sumberdaya Teknologi Informasi dan Komunikasi'],
            ['nama' => 'Bidang Infrastruktur Teknologi Informasi dan Komunikasi'],
            ['nama' => 'Bidang Data dan Statistik'],
            ['nama' => 'Bidang Persandian dan Aplikasi Informatika'],
            ['nama' => 'Bidang Diseminasi Informasi'],
            ['nama' => 'Unit Pelaksana Teknis Pusat Manajemen Informasi Pemerintahan'],
            ['nama' => 'Unit Pelaksana Teknis Radio Sonata'],
            ['nama' => 'Other'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang');
    }
};
