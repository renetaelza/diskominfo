<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'isi_pengumuman', 'topik_id', 'tanggal', 'status', 'lampiran'];
    protected $casts = [
        'lampiran' => 'array',
        'tanggal' => 'datetime',
    ];

    public function topik()
    {
        return $this->belongsTo(Topik::class, 'topik_id');
    }
}
