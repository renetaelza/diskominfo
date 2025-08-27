<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
    protected $table = 'kategori_dokumen';
    protected $fillable = ['nama'];

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'kategoriDokumen_id');
    }
}
