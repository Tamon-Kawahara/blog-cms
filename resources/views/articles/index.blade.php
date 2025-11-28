<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">
            @isset($currentCategory)
                Category: {{ $currentCategory->name }}
            @elseif(isset($currentTag))
                Tag: {{ $currentTag->name }}
            @else
                Articles
            @endisset
        </h1>
    </x-slot>

    <div class="bg-gray-100">
        <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @if ($articles->isEmpty())
                <p class="text-gray-600">まだ記事がありません。</p>
            @else
                <div class="space-y-6">
                    @foreach ($articles as $article)
                        <article
                            class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <a href="{{ route('articles.show', $article) }}"
                                class="flex flex-col sm:flex-row gap-4 p-4 sm:p-5">
                                @if ($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                                        class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-md border border-red-500">
                                @endif

                                <div class="flex-1">
                                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 line-clamp-2">
                                        {{ $article->title }}
                                    </h2>

                                    <div
                                        class="mt-1 text-xs sm:text-sm text-gray-500 flex flex-wrap items-center gap-x-2 gap-y-1">
                                        <span>
                                            {{ optional($article->published_at)->format('Y-m-d') }}
                                        </span>

                                        <span class="text-gray-400">/</span>

                                        @if ($article->category)
                                            <a href="{{ route('articles.byCategory', $article->category) }}"
                                                class="text-gray-700 hover:text-blue-600 hover:underline">
                                                {{ $article->category->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">未分類</span>
                                        @endif>
                                    </div>

                                    @if ($article->tags->isNotEmpty())
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            @foreach ($article->tags as $tag)
                                                <a href="{{ route('articles.byTag', $tag) }}"
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs border border-gray-200 text-gray-600 hover:bg-gray-100">
                                                    {{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    @php
                                        $excerpt = \Illuminate\Support\Str::limit(
                                            strip_tags($article->body_html ?? $article->body),
                                            110,
                                        );
                                    @endphp

                                    <p class="mt-3 text-sm text-gray-700 line-clamp-3">
                                        {{ $excerpt }}
                                    </p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
