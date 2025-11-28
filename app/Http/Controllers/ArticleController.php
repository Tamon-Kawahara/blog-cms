<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;


class ArticleController extends Controller
{
    // 記事一覧（公開済みだけ）
    public function index()
    {
        $articles = Article::published()
        ->with(['category', 'tags'])
        ->orderByDesc('published_at')
        ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    // 記事詳細
    public function show(Article $article)
    {
        // slugでハインドされて飛んでくる

        // 下書きだったら404にしておく（URL直撃ち対策）
        if ($article->status !== 'published'){
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}
