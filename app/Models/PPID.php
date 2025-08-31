<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPID extends Model
{
    protected $table = 'ppid_dokumen';
    protected $fillable = ['judul', 'konten', 'slug', 'tanggal', 'lampiran'];
    protected $casts = [
        'lampiran' => 'array',
        'tanggal' => 'datetime',
    ];
}
