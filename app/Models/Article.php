<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // 一括代入可能なカラム
    protected $fillable = [
        'title',
        'slug',
        'body',
        'thumbnail',
        'status',
        'category_id',
        'published_at',
    ];

    /** カテゴリ:1記事は1カテゴリに属する */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** タグ:多対多 */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /** 公開済みスコープ（後で便利） */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
