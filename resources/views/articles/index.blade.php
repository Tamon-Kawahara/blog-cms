<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
                @if (isset($currentCategory))
                    カテゴリー: {{ $currentCategory->name }}
                @elseif (isset($currentTag))
                    タグ: {{ $currentTag->name }}
                @else
                    記事一覧
                @endif
            </h1>

            <div class="flex items-center gap-2">
                {{-- 公開サイトのトップへ --}}
                <a href="{{ url('/') }}"
                    class="inline-flex items-center px-3 py-2 text-xs sm:text-sm rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                    トップに戻る
                </a>

                {{-- ログインしている場合だけ管理画面への導線も --}}
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-3 py-2 text-xs sm:text-sm rounded-md bg-gray-800 text-white hover:bg-gray-900">
                        管理画面へ
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-100">
        <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            {{-- メイン + サイドバー --}}
            <div class="lg:flex lg:items-start lg:gap-8">
                {{-- メインコンテンツ --}}
                <div class="flex-1">
                    @if ($articles->isEmpty())
                        <p class="text-gray-600">まだ記事がありません。</p>
                    @else
                        {{-- カードを2列グリッドで表示 --}}
                        <div class="grid gap-6 md:grid-cols-2">
                            @foreach ($articles as $article)
                                @php
                                    $excerpt = \Illuminate\Support\Str::limit(
                                        strip_tags($article->body_html ?? $article->body),
                                        80,
                                    );
                                @endphp

                                <article
                                    class="relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">

                                    {{-- カード全体を覆う透明リンク --}}
                                    <a href="{{ route('articles.show', $article) }}" class="absolute inset-0 z-10">
                                        <span class="sr-only">{{ $article->title }}へ</span>
                                    </a>

                                    {{-- ここからは普通のカード内容 --}}
                                    @if ($article->thumbnail)
                                        <div class="aspect-[4/3] overflow-hidden">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif

                                    <div class="p-4 sm:p-5">
                                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                            <span>{{ optional($article->published_at)->format('Y/m/d') }}</span>

                                            @if ($article->category)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full border border-blue-200 text-[10px] text-white bg-blue-500">
                                                    {{ $article->category->name }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-[11px]">未分類</span>
                                            @endif
                                        </div>

                                        <h2 class="text-base sm:text-lg font-semibold text-gray-900 line-clamp-2">
                                            {{ $article->title }}
                                        </h2>

                                        @if ($article->tags->isNotEmpty())
                                            <div class="mt-2 flex flex-wrap gap-1">
                                                @foreach ($article->tags as $tag)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] border border-gray-200 text-gray-600">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- <p class="mt-3 text-sm text-gray-700 line-clamp-3">
                                            {{ $excerpt }}
                                        </p> --}}
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- ページネーション --}}
                        <div class="mt-8">
                            {{ $articles->withQueryString()->links() }}
                        </div>

                    @endif
                </div>

                {{-- サイドバー --}}
                @include('articles.partials.sidebar')

            </div>
        </div>
    </div>
</x-app-layout>
