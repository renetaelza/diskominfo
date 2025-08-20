<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';
    protected $fillable = ['nama_dokumen', 'deskripsi_dokumen',  'kategoriDokumen_id', 'tanggal', 'status', 'lampiran'];
    protected $casts = [
        'lampiran' => 'array',
        'tanggal' => 'datetime',
    ];

    public function kategoriDokumen()
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategoriDokumen_id');
    }
}
