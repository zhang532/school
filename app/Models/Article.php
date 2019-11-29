<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = 'Article';
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
