<x-app-layout>
    <x-slot name="header">
        <div class="max-w-5xl mx-auto flex flex-col gap-2">
            <p class="text-xs text-gray-500">
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

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                {{ $article->title }}
            </h1>

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
    </x-slot>

    <div class="bg-gray-100">
        <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <article class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-8">
                @if ($article->thumbnail)
                    <div class="mb-6 flex justify-center">
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                            class="max-w-xs w-full h-auto object-contain rounded-md shadow-sm">
                    </div>
                @endif

                <div class="prose max-w-none prose-sm sm:prose-base">
                    {!! $article->body_html !!}
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
