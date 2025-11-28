<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // カテゴリとタグを取得(フォームの選択肢用)
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:articles,slug'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]);

        // スラッグが未入力なら自動生成
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // 公開状態でpublished_at未設定なら今の時間
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // サムネ画像の保存処理
        if ($request->hasFile('thumbnail')) {
            // storage/app/public/thumbnailsに保存される
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        // 記事作成
        $article = Article::create($validated);

        // タグの紐付け
        if (!empty($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        // カテゴリとタグを取得（フォームの選択肢用）
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        // 記事本体+選択肢をビューに渡す
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            // 自分自身は除外してslugのユニークチェック
            'slug' => ['nullable', 'string', 'max:255', 'unique:articles,slug,' . $article->id],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'remove_thumbnail' => ['nullable', 'boolean'],
        ]);

        // スラッグが未入力なら自動生成
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $removeThumbnail = $request->boolean('remove_thumbnail');


        if ($removeThumbnail) {
            // サムネ削除指定がある場合
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = null;
        }

        // サムネ画像の更新（新しいのがきた時だけ上書き）
        elseif ($request->hasFile('thumbnail')) {
            // 既存のサムネがあれば削除
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            // storage/app/public/thumbnailに保存
            $path = $request->file('thumbnail')->store('thumbnail', 'public');
            $validated['thumbnail'] = $path;
        } else {
            // 新しいファイルがない場合はthumbnailを更新対象から外す
            unset($validated['thumbnail']);
        }

        // published_atの制御
        if ($validated['status'] === 'published') {
            // まだ日付がない or draftから公開した時にはnowを入れる
            $validated['published_at'] = $article->published_at ?? now();
        } else {
            // draftに戻したらpublished_atはnullに
            $validated['published_at'] = null;
        }

        // 記事更新
        $article->update($validated);

        // タグの紐付け更新
        $article->tags()->sync($validated['tags'] ?? []);

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // ここで画像ファイル削除したければ後から追記をする
        // if ($article->thumbnail) {
        //     Storage::disk('public')->delete($article->thumbnail);
        // }

        $article->delete(); // article_tagはFKのcascadeOnDeleteで一緒に消える

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Article deleted successfully.');
    }
}
