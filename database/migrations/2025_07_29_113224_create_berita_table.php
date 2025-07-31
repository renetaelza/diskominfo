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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi_berita');
            $table->foreignId('kategori_id')->constrained('bidang')->onDelete('cascade');
            $table->dateTime('tanggal');
            $table->unsignedInteger('views')->default(0);
            $table->enum('status', ['publikasi', 'draft'])->default('draft');
            $table->string('foto_utama');
            $table->json('foto_tambahan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
