<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->get();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tags,slug'],
        ]);

        // slug 未入力なら自動生成
        if (empty($validated['slug'])) {
            $base = Str::slug($validated['name'], '-');

            // 日本語オンリーでslugが空になる場合のフォールバック
            if ($base === '') {
                $base = 'tag';
            }

            // 重複していたらtag-1,tag-2...にしてユニークに
            $slug = $base;
            $i = 1;
            while (Tag::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $validated['slug'] = $slug;
        }

        Tag::create($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'Tag created successfully.');
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
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tags,slug,' . $tag->id],
        ]);

        if (empty($validated['slug'])) {
            $base = Str::slug($validated['name'], '-');

            if ($base === '') {
                $base = 'tag';
            }

            $slug = $base;
            $i = 1;
            while (Tag::where('slug', $slug)->where('id', '!=', $tag->id)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $validated['slug'] = $slug;
        }

        $tag->update($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // 記事との中間テーブルはFKのcascadeOnDeleteで消える想定
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'Tag deleted successfully.');
    }
}
