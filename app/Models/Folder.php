<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['title', 'description', 'folder_date'];

    public function photos()
    {
        return $this->hasMany(FolderPhoto::class);
    }
}
