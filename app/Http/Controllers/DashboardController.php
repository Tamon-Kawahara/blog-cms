<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();

        $categoriesCount = Category::count();
        $tagsCount = Tag::count();

        $recentArticles = Article::with('category')
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalArticles' => $totalArticles,
            'publishedArticles' => $publishedArticles,
            'draftArticles' => $draftArticles,
            'categoriesCount' => $categoriesCount,
            'tagsCount' => $tagsCount,
            'recentArticles' => $recentArticles,
        ]);
    }
}
