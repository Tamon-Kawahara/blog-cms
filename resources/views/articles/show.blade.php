{{-- resources/views/articles/show.blade.php --}}
<x-app-layout>
    {{-- 上のバーのタイトルはシンプルに --}}
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">
            記事詳細
        </h1>
    </x-slot>

    <div class="bg-gray-100">
        <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-start lg:gap-8">
                {{-- メイン記事 --}}
                <article class="flex-1 bg-white rounded-lg shadow-sm overflow-hidden">
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
                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                alt="{{ $article->title }}"
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
                </article>

                {{-- サイドバー（今はダミー） --}}
                @include('articles.partials.sidebar')

            </div>
        </div>
    </div>
</x-app-layout>
