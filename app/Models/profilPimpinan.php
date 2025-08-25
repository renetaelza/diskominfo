<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class profilPimpinan extends Model
{
    protected $fillable = [
        'name',
        'title',
        'photo_path',
        'welcome_message',
    ];
}
