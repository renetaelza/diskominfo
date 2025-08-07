<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'isi_pengumuman', 'kategori_id', 'tanggal', 'status', 'lampiran'];
    protected $casts = [
        'lampiran' => 'array',
        'tanggal' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Bidang::class, 'kategori_id');
    }
}
