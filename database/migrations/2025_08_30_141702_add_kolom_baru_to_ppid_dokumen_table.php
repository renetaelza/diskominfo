<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ppid_dokumen', function (Blueprint $table) {
            $table->longText('konten')->nullable()->after('judul'); // kolom untuk CKEditor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ppid_dokumen', function (Blueprint $table) {
            $table->dropColumn('konten');
        });
    }
};
