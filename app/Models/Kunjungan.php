<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kunjungan extends Model

{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'nama_lengkap', 'email', 'nik', 'instansi', 'jabatan',
        'tanggal_kunjungan', 'pukul_kunjungan', 'tujuan', 'bidang_id', 'status',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

}
