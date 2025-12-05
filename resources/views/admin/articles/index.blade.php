<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- ヘッダー行 --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <div class="flex flex-col gap-1">
                        <h1 class="text-2xl font-bold">記事一覧</h1>

                        {{-- 管理画面内ナビ（ダッシュボードへの戻り） --}}
                        <div class="flex flex-wrap gap-2 text-xs text-gray-600">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-2 py-1 rounded-md border border-gray-200 hover:bg-gray-50">
                                ダッシュボードに戻る
                            </a>

                            <a href="{{ url('/') }}" target="_blank"
                                class="inline-flex items-center px-2 py-1 rounded-md border border-gray-200 hover:bg-gray-50">
                                公開サイトを見る
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.articles.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            記事を追加
                        </a>
                        <a href="{{ route('admin.categories.create') }}"
                            class="bg-gray-100 text-gray-800 px-4 py-2 rounded text-sm hover:bg-gray-200">
                            カテゴリーを追加
                        </a>
                        <a href="{{ route('admin.tags.create') }}"
                            class="bg-gray-100 text-gray-800 px-4 py-2 rounded text-sm hover:bg-gray-200">
                            タグを追加
                        </a>
                    </div>
                </div>

                {{-- 検索フォーム --}}
                <form method="GET" action="{{ route('admin.articles.index') }}" class="mb-6">
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4 flex flex-wrap items-end gap-4">

                        {{-- キーワード --}}
                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                キーワード
                            </label>
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="w-full border-gray-300 rounded-md text-sm" placeholder="タイトル・本文から検索">
                        </div>

                        {{-- ステータス --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                ステータス
                            </label>
                            <select name="status" class="border-gray-300 rounded-md text-sm">
                                <option value="">すべて</option>
                                <option value="published" @selected(request('status') === 'published')>公開</option>
                                <option value="draft" @selected(request('status') === 'draft')>下書き</option>
                            </select>
                        </div>

                        {{-- カテゴリー --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                カテゴリー
                            </label>
                            <select name="category_id" class="border-gray-300 rounded-md text-sm">
                                <option value="">すべて</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ボタン --}}
                        <div class="flex gap-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-700">
                                検索
                            </button>
                            <a href="{{ route('admin.articles.index') }}"
                                class="inline-flex items-center px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 text-xs hover:bg-gray-50">
                                条件をリセット
                            </a>
                        </div>
                    </div>
                </form>

                {{-- 一覧テーブル --}}
                <div class="overflow-x-auto">
                    <table class="min-w-[720px] md:min-w-full border-collapse text-sm md:text-base">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-2 md:px-4 py-2 text-left">
                                    タイトル
                                </th>
                                <th class="border px-2 md:px-4 py-2 text-left hidden sm:table-cell">
                                    カテゴリー
                                </th>
                                <th class="border px-2 md:px-4 py-2 text-left hidden md:table-cell">
                                    タグ
                                </th>
                                <th class="border px-2 md:px-4 py-2 text-left w-24">
                                    公開状態
                                </th>
                                <th class="border px-2 md:px-4 py-2 text-left w-24">
                                    操作
                                </th>
                                <th class="border px-2 md:px-4 py-2 text-left hidden md:table-cell">
                                    サムネイル
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr class="hover:bg-gray-50">
                                    {{-- タイトル --}}
                                    <td class="border px-2 md:px-4 py-2 align-top">
                                        <div class="font-medium text-gray-900 text-sm md:text-base">
                                            {{ $article->title }}
                                        </div>

                                        {{-- スマホ用：サムネ + カテゴリ・タグの簡易表示 --}}
                                        <div class="mt-2 flex items-start gap-3 sm:hidden">
                                            @if ($article->thumbnail)
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                        alt="{{ $article->title }}"
                                                        class="w-12 h-12 object-cover rounded">
                                                </div>
                                            @endif

                                            <div class="space-y-1 text-xs text-gray-500">
                                                @if ($article->category)
                                                    <div>カテゴリ：{{ $article->category->name }}</div>
                                                @endif
                                                @if ($article->tags->isNotEmpty())
                                                    <div class="flex flex-wrap">
                                                        <span class="mr-1">タグ：</span>
                                                        @foreach ($article->tags as $tag)
                                                            <span
                                                                class="inline-block bg-gray-200 px-1 py-0.5 rounded mr-1 mb-0.5">
                                                                {{ $tag->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- カテゴリー（sm以上） --}}
                                    <td class="border px-2 md:px-4 py-2 hidden sm:table-cell align-top">
                                        {{ $article->category->name ?? '—' }}
                                    </td>

                                    {{-- タグ（md以上） --}}
                                    <td class="border px-2 md:px-4 py-2 hidden md:table-cell align-top">
                                        @forelse ($article->tags as $tag)
                                            <span
                                                class="inline-block text-xs md:text-sm bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                                                {{ $tag->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">タグなし</span>
                                        @endforelse
                                    </td>

                                    {{-- 公開状態 --}}
                                    <td class="border px-2 md:px-4 py-2 align-top">
                                        @if ($article->status === 'published')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-green-50 text-green-700">
                                                公開
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">
                                                下書き
                                            </span>
                                        @endif
                                    </td>

                                    {{-- 操作 --}}
                                    <td class="border px-2 md:px-4 py-2 align-top">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                class="text-blue-600 text-sm md:text-base hover:underline">
                                                編集
                                            </a>

                                            <form action="{{ route('admin.articles.destroy', $article->id) }}"
                                                method="POST" onsubmit="return confirm('この記事を削除してもよろしいですか？');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 text-sm md:text-base hover:underline">
                                                    削除
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    {{-- サムネイル（md以上） --}}
                                    <td class="border px-2 md:px-4 py-2 hidden md:table-cell align-top">
                                        @if ($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                alt="{{ $article->title }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <span class="text-xs text-gray-400">なし</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                                        記事がまだ登録されていません。
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $articles->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
