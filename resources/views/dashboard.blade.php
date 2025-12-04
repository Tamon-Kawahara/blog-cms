<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ダッシュボード
            </h2>

            <div class="flex items-center gap-2">
                <a href="{{ url('/') }}" target="_blank"
                    class="inline-flex items-center px-3 py-2 text-xs sm:text-sm rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                    公開サイトを見る
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 上部のサマリーカード --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- 記事数 --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500">記事数</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalArticles }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        @if ($totalArticles === 0)
                            まだ記事がありません。まずは最初の1件を作成してみましょう。
                        @else
                            公開 {{ $publishedArticles }} / 下書き {{ $draftArticles }}
                        @endif
                    </p>
                </div>

                {{-- カテゴリー --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500">カテゴリー</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $categoriesCount }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        @if ($categoriesCount === 0)
                            まだカテゴリーがありません。あとからでも整理できます。
                        @else
                            記事の分類に使われます
                        @endif
                    </p>
                    <div class="mt-3 text-right">
                        <a href="{{ route('admin.categories.index') }}" class="text-xs text-blue-600 hover:underline">
                            カテゴリー一覧へ
                        </a>
                    </div>
                </div>

                {{-- タグ --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500">タグ</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $tagsCount }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        @if ($tagsCount === 0)
                            まだタグがありません。細かく分類したくなったら追加しましょう。
                        @else
                            記事の特徴づけに使われます
                        @endif
                    </p>
                    <div class="mt-3 text-right">
                        <a href="{{ route('admin.tags.index') }}" class="text-xs text-blue-600 hover:underline">
                            タグ一覧へ
                        </a>
                    </div>
                </div>
            </div>

            {{-- クイックアクション --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">
                    クイック操作
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.articles.create') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-700">
                        記事を追加
                    </a>
                    <a href="{{ route('admin.articles.index') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-800 text-sm hover:bg-gray-200">
                        記事一覧（管理）
                    </a>
                    <a href="{{ route('admin.categories.create') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-800 text-sm hover:bg-gray-200">
                        カテゴリーを追加
                    </a>
                    <a href="{{ route('admin.tags.create') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-800 text-sm hover:bg-gray-200">
                        タグを追加
                    </a>
                </div>
            </div>

            {{-- 最近更新した記事 --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">
                    最近更新した記事
                </h3>

                @if ($recentArticles->isEmpty())
                    <p class="text-sm text-gray-500 mb-4">
                        まだ記事がありません。まずは最初の記事を作成してみましょう。
                    </p>
                    <a href="{{ route('admin.articles.create') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-700">
                        記事を追加する
                    </a>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($recentArticles as $article)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="text-sm font-medium text-gray-900 hover:underline">
                                        {{ $article->title }}
                                    </a>
                                    <div class="mt-1 text-xs text-gray-500 flex items-center gap-2">
                                        <span>
                                            {{ optional($article->published_at)->format('Y-m-d') ?? '未公開' }}
                                        </span>
                                        @if ($article->category)
                                            <span class="text-gray-400">/</span>
                                            <span>{{ $article->category->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
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
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
