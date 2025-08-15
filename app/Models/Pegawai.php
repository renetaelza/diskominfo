<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nama', 'nip', 'bidang_id', 'jabatan', 'atasan_id',
        'alamat', 'tupoksi', 'foto', 'is_assistant',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(Pegawai::class, 'atasan_id');
    }
}
