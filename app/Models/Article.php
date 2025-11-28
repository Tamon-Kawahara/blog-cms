<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

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

    // Markdownの本文をHTMLに変換して返すアクセサ
    // $article->body_htmlで使える
    public function getBodyHtmlAttribute():string
    {
        static $converter = null;

        if ($converter === null){
            $converter = new CommonMarkConverter([
                'html_input' => 'escape',       // 生HTMLはエスケープ
                'allow_unsafe_links' => false,
            ]);
        }

        return $converter->convert($this->body ?? '')->getContent();
    }
}
