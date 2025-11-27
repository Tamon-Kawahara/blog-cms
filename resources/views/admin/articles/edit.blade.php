<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Article
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Edit Article</h1>

                {{-- エラー表示 --}}
                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.articles.update', $article->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Title
                        </label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}"
                            class="w-full rounded border-gray-300 shadow-sm">
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Slug <span class="text-xs text-gray-500">(empty = auto generate)</span>
                        </label>
                        <input type="text" name="slug" value="{{ old('slug', $article->slug) }}"
                            class="w-full rounded border-gray-300 shadow-sm">
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Category
                        </label>
                        <select name="category_id" class="w-full rounded border-gray-300 shadow-sm">
                            <option value="">No category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tags --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Tags
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $selectedTags = collect(old('tags', $article->tags->pluck('id')->toArray()));
                            @endphp

                            @foreach ($tags as $tag)
                                <label class="inline-flex items-center text-sm">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="mr-1"
                                        @checked($selectedTags->contains($tag->id))>
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Body --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Body
                        </label>
                        <textarea name="body" rows="10" class="w-full rounded border-gray-300 shadow-sm">{{ old('body', $article->body) }}</textarea>
                    </div>

                    {{-- Thumbnail（現状表示は後ででOK） --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Thumbnail
                        </label>
                        <input type="file" name="thumbnail" class="block w-full text-sm">
                        {{-- 既存サムネのプレビューは、気が向いたら後で追加 --}}
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Status
                        </label>
                        <select name="status" class="w-full rounded border-gray-300 shadow-sm">
                            <option value="draft" @selected(old('status', $article->status) === 'draft')>
                                Draft
                            </option>
                            <option value="published" @selected(old('status', $article->status) === 'published')>
                                Published
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.articles.index') }}"
                            class="px-4 py-2 rounded border border-gray-300 text-gray-700">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">
                            Update
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
