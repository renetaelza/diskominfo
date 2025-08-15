<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    use HasFactory;

    protected $table = 'aplikasi';
    protected $fillable = ['halaman', 'tagline', 'deskripsi', 'subheading1', 'text1', 'subheading2', 'text2', 'subheading3', 'text3', 'foto', 'link'];
}
