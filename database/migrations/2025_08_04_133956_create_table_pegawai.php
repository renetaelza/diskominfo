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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->unique();
            $table->foreignId('bidang_id')->constrained('bidang')->onDelete('cascade');
            $table->string('jabatan')->nullable();
            $table->foreignId('atasan_id')->nullable()->constrained('pegawai')->nullOnDelete();
            $table->string('alamat')->nullable();
            $table->text('tupoksi')->nullable();
            $table->string('foto')->nullable(); // jika pakai upload foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pegawai');
    }
};

