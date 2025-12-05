<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">
            記事詳細
        </h1>
    </x-slot>

    <div class="bg-gray-100">
        <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            {{-- パンくず --}}
            <nav class="text-sm text-gray-500 mb-2">
                <a href="{{ route('articles.index') }}" class="hover:underline">
                    ホーム
                </a>

                @if ($article->category)
                    <span class="mx-1">/</span>
                    <a href="{{ route('articles.byCategory', $article->category) }}" class="hover:underline">
                        {{ $article->category->name }}
                    </a>
                @endif

                <span class="mx-1">/</span>
                <span class="text-gray-700">
                    {{ $article->title }}
                </span>
            </nav>
            
            <div class="lg:flex lg:items-start lg:gap-8">
                {{-- メインカラム：記事＋関連記事 --}}
                <div class="flex-1 space-y-8">

                    {{-- メイン記事 --}}
                    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 sm:p-8 pb-4">
                            {{-- カテゴリ --}}
                            <p class="text-xs text-gray-500 mb-1">
                                @if ($article->category)
                                    <a href="{{ route('articles.byCategory', $article->category) }}"
                                        class="uppercase tracking-wide text-blue-600 font-semibold hover:underline">
                                        {{ $article->category->name }}
                                    </a>
                                @else
                                    <span class="uppercase tracking-wide text-gray-400 font-semibold">
                                        未分類
                                    </span>
                                @endif
                            </p>

                            {{-- タイトル --}}
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-2">
                                {{ $article->title }}
                            </h1>

                            {{-- 日付 & タグ --}}
                            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                <span>{{ optional($article->published_at)->format('Y-m-d') }}</span>

                                @if ($article->tags->isNotEmpty())
                                    <span class="text-gray-400">/</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($article->tags as $tag)
                                            <a href="{{ route('articles.byTag', $tag) }}"
                                                class="inline-flex items-center px-2 py-0.5 rounded-full border border-gray-200 hover:bg-gray-100">
                                                {{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- アイキャッチ画像（横いっぱい） --}}
                        @if ($article->thumbnail)
                            <div class="w-full max-h-[420px] overflow-hidden">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        {{-- 本文 --}}
                        <div class="p-6 sm:p-8">
                            <div class="prose max-w-none prose-sm sm:prose-base">
                                @if (!empty($article->body_html))
                                    {!! $article->body_html !!}
                                @else
                                    {!! nl2br(e($article->body)) !!}
                                @endif
                            </div>
                        </div>

                        {{-- 前の記事 / 次の記事 --}}
                        @if (!empty($previousArticle) || !empty($nextArticle))
                            <div class="mt-10 pt-6 px-6 sm:px-8 pb-6 border-t border-gray-100 bg-gray-50">
                                <div class="flex flex-col sm:flex-row justify-between gap-4 text-sm">
                                    @if (!empty($previousArticle))
                                        <a href="{{ route('articles.show', $previousArticle) }}"
                                            class="flex-1 text-left group rounded-md p-3 hover:bg-white hover:shadow-sm transition">
                                            <div class="text-xs text-gray-400 mb-1">前の記事</div>
                                            <div class="text-gray-800 group-hover:text-blue-600 line-clamp-2">
                                                {{ $previousArticle->title }}
                                            </div>
                                        </a>
                                    @else
                                        <div class="flex-1"></div>
                                    @endif
                                    @if (!empty($nextArticle))
                                        <a href="{{ route('articles.show', $nextArticle) }}"
                                            class="flex-1 text-right group rounded-md p-3 hover:bg-white hover:shadow-sm transition">
                                            <div class="text-xs text-gray-400 mb-1">次の記事</div>
                                            <div class="text-gray-800 group-hover:text-blue-600 line-clamp-2">
                                                {{ $nextArticle->title }}
                                            </div>
                                        </a>
                                    @else
                                        <div class="flex-1"></div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </article>

                    {{-- 関連記事 --}}
                    @if (!empty($relatedArticles) && $relatedArticles->isNotEmpty())
                        <section class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-sm font-semibold text-gray-800 mb-4">
                                関連記事
                            </h2>
                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach ($relatedArticles as $related)
                                    <a href="{{ route('articles.show', $related) }}"
                                        class="flex gap-3 items-center p-3 rounded-lg hover:bg-gray-50 transition">
                                        @if ($related->thumbnail)
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                                    alt="{{ $related->title }}" class="w-16 h-16 object-cover rounded">
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="text-xs text-gray-400 mb-1">
                                                {{ optional($related->published_at)->format('Y-m-d') }}
                                                @if ($related->category)
                                                    ・{{ $related->category->name }}
                                                @endif
                                            </div>
                                            <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                {{ $related->title }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                {{-- サイドバー --}}
                @include('articles.partials.sidebar')
            </div>
        </div>
    </div>
</x-app-layout>
