<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;


class ArticleController extends Controller
{
    // 記事一覧（公開済みだけ）
    public function index()
    {
        $articles = Article::published()
        ->with(['category', 'tags'])
        ->orderByDesc('published_at')
        ->paginate(10);

        // サイドバー用：公開済み記事だけカウント
        $categories = Category::withCount(['articles' => function($query){
            $query->where('status', 'published');
        }])
        ->orderBy('name')
        ->get();

        $recentArticles = Article::published()
        ->orderByDesc('published_at')
        ->limit(5)
        ->get();

        return view('articles.index', compact('articles', 'categories', 'recentArticles'));
    }

    // 記事詳細
    public function show(Article $article)
    {
        // 関連をロードしておく（N＋1対策）
        $article->load(['category', 'tags']);

        // 下書きだったら404にしておく（URL直撃ち対策）
        abort_if ($article->status !== 'published',404);

                // サイドバー用：公開済み記事だけカウント
        $categories = Category::withCount(['articles' => function($query){
            $query->where('status', 'published');
        }])
        ->orderBy('name')
        ->get();

        $recentArticles = Article::published()
        ->orderByDesc('published_at')
        ->limit(5)
        ->get();

        return view('articles.show', compact('article', 'categories', 'recentArticles'));
    }

    // カテゴリ別記事一覧
    public function byCategory(Category $category)
    {
        $articles = $category->articles()
        ->where('status', 'published')
        ->with(['category', 'tags'])
        ->orderByDesc('published_at')
        ->paginate(10);

        return view('articles.index', [
            'articles' => $articles,
            'currentCategory' => $category,
        ]);
    }

    // タグ別記事一覧
    public function byTag(Tag $tag)
    {
        $articles = $tag->articles()
        ->where('status', 'published')
        ->with(['category', 'tags'])
        ->orderByDesc('published_at')
        ->paginate(10);

        return view('articles.index', [
            'articles' => $articles,
            'currentTag' => $tag,
        ]);
    }
}
