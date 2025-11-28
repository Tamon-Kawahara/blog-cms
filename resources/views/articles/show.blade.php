<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">
            {{ $article->title }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 space-y-6">
        <div class="text-sm text-gray-500">
            {{ optional($article->published_at)->format('Y-m-d') }}
            ／ {{ $article->category->name ?? '未分類' }}
        </div>

        <div class="space-x-1">
            @foreach ($article->tags as $tag)
                <span class="inline-block text-xs px-2 py-1 bg-gray-100 rounded">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>

        @if ($article->thumbnail)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                    class="w-full max-h-96 object-cover rounded">
            </div>
        @endif

        <div class="prose max-w-none mt-6">
            {!! $article->body_html !!}
        </div>
    </div>
</x-app-layout>
