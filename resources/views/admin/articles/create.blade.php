<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事を新規作成
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">記事を新規作成</h1>

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

                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    {{-- タイトル --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            タイトル
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full rounded border-gray-300 shadow-sm">
                    </div>

                    {{-- スラッグ --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            スラッグ
                            <span class="text-xs text-gray-500">
                                （未入力の場合は自動生成）
                            </span>
                        </label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                            class="w-full rounded border-gray-300 shadow-sm">
                    </div>

                    {{-- カテゴリー --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            カテゴリー
                        </label>
                        <select name="category_id" class="w-full rounded border-gray-300 shadow-sm">
                            <option value="">カテゴリーなし</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- タグ --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            タグ
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <label class="inline-flex items-center text-sm">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="mr-1"
                                        @checked(collect(old('tags', []))->contains($tag->id))>
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @if ($tags->isEmpty())
                            <p class="text-xs text-gray-500 mt-1">
                                まだタグが登録されていません。タグ管理画面から追加できます。
                            </p>
                        @endif
                    </div>

                    {{-- 本文 --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            本文
                        </label>
                        <textarea name="body" rows="10" class="w-full rounded border-gray-300 shadow-sm">{{ old('body') }}</textarea>
                    </div>

                    {{-- サムネイル --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            サムネイル
                        </label>
                        <input type="file" name="thumbnail" class="block w-full text-sm">
                        @error('thumbnail')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 公開状態 --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            公開状態
                        </label>
                        <select name="status" class="w-full rounded border-gray-300 shadow-sm">
                            <option value="draft" @selected(old('status') === 'draft')>
                                下書き
                            </option>
                            <option value="published" @selected(old('status') === 'published')>
                                公開
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.articles.index') }}"
                            class="px-4 py-2 rounded border border-gray-300 text-gray-700">
                            キャンセル
                        </a>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">
                            保存する
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
