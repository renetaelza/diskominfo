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
        Schema::create('aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug');
            $table->string('tagline');
            $table->text('deskripsi')->nullable();

            $table->string('subheading1')->nullable();
            $table->text('text1')->nullable();

            $table->string('subheading2')->nullable();
            $table->text('text2')->nullable();

            $table->string('subheading3')->nullable();
            $table->text('text3')->nullable();

            $table->string('foto')->nullable();
            $table->string('link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplikasi');
    }
};
