<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /** このタグがついている記事一覧 */
    public function articles(){
        return $this->belongsToMany(Article::class);
    }
}
