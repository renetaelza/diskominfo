<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderPhoto extends Model
{
    protected $fillable = ['folder_id', 'image_path'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
