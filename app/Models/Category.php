<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /** このカテゴリに属する記事一覧 */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
