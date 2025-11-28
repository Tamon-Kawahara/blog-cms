<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">
            @isset($currentCategry)
                Category: {{ $currentCategory->name }}
            @elseif(isset($currentTag))
                Tag: {{ $currentTag->name }}
            @else
                Articles
            @endisset
        </h1>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 space-y-6">
        @forelse ($articles as $article)
            <article class="border rounded-lg p-4 bg-white">
                <div class="flex gap-4">
                    @if ($article->thumbnail)
                        <div class="w-32 h-32 flex-shrink-0">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                                class="w-full h-full object-cover rounded">
                        </div>
                    @endif

                    <div class="flex-1">
                        <h2 class="text-xl font-semibold">
                            <a href="{{ route('articles.show', $article) }}" class="text-blue-600 hover:underline">
                                {{ $article->title }}
                            </a>
                        </h2>

                        <div class="text-sm text-gray-500 mt-1">
                            {{ optional($article->published_at)->format('Y-m-d') }}
                            カテゴリ⇨
                            @if ($article->category)
                                <a href="{{ route('articles.byCategory', $article->category) }}"
                                    class="text-gray-700 hover:underline">
                                    {{ $article->category->name }}
                                </a>
                            @else
                                未分類
                            @endif
                        </div>

                        <div class="mt-2 space-x-1">
                            @foreach ($article->tags as $tag)
                                <a href="{{ route('articles.byTag', $tag) }}"
                                    class="inline-block text-xs px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                        @php
                            $excerpt = \Illuminate\Support\Str::limit(strip_tags($article->body_html), 100);
                        @endphp
                        <p class="mt-3 text-gray-700 text-sm">
                            {{ $excerpt }}
                        </p>
                    </div>
                </div>
            </article>
        @empty
            <p>まだ記事がありません。</p>
        @endforelse

        <div>
            {{ $articles->links() }}
        </div>
    </div>
</x-app-layout>
