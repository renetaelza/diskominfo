<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_agenda',
        'deskripsi',
        'tanggal',
        'lokasi',
        'foto',
        'kategori_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'kategori_id');
    }
}
