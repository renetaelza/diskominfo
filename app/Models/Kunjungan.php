<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $table = 'kunjungan';

    protected $fillable = [
        'nama', 'nama_instansi', 'nomor_hp', 'email', 'kab_kota', 'alamat_instansi',
        'tanggal_kunjungan', 'pukul_kunjungan', 'topik_diskusi', 'jumlah_rombongan',
        'no_surat', 'tanggal_surat', 'surat_permohonan', 'status',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    /**
     * The bidang(s) that belong to the Kunjungan.
     */
    public function bidangs()
    {
        // Define the many-to-many relationship
        return $this->belongsToMany(Bidang::class, 'bidang_kunjungan');
    }
}