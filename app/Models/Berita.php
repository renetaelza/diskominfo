<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $fillable = ['judul', 'isi_berita', 'kategori_id', 'tanggal', 'views', 'status', 'foto_utama', 'foto_tambahan'];
    protected $casts = [
        'foto_tambahan' => 'array',
        'tanggal' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Bidang::class, 'kategori_id');
    }
}
