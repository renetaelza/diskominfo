<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';
    protected $fillable = ['nama_dokumen', 'deskripsi_dokumen', 'kategori', 'tanggal', 'lampiran'];
    protected $casts = [
        'lampiran' => 'array',
        'tanggal' => 'datetime',
    ];
}
