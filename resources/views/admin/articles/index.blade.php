<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- ヘッダー行 --}}
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">記事一覧</h1>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.articles.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            記事を追加
                        </a>
                        <a href="{{ route('admin.categories.create') }}"
                            class="bg-gray-100 text-gray-800 px-4 py-2 rounded text-sm hover:bg-gray-200">
                            カテゴリーを追加
                        </a>
                        <a href="{{ route('admin.tags.create') }}"
                            class="bg-gray-100 text-gray-800 px-4 py-2 rounded text-sm hover:bg-gray-200">
                            タグを追加
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm md:text-base">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-2 md:px-4 py-2 text-left">タイトル</th>
                                <th class="border px-2 md:px-4 py-2 text-left">カテゴリー</th>
                                <th class="border px-2 md:px-4 py-2 text-left">タグ</th>
                                <th class="border px-2 md:px-4 py-2 text-left">公開状態</th>
                                <th class="border px-2 md:px-4 py-2 text-left">操作</th>
                                <th class="border px-2 md:px-4 py-2 text-left">サムネイル</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $article->title }}
                                    </td>

                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $article->category->name ?? '—' }}
                                    </td>

                                    <td class="border px-2 md:px-4 py-2">
                                        @forelse ($article->tags as $tag)
                                            <span
                                                class="inline-block text-xs md:text-sm bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                                                {{ $tag->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">タグなし</span>
                                        @endforelse
                                    </td>

                                    <td class="border px-2 md:px-4 py-2">
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
                                    </td>

                                    <td class="border px-2 md:px-4 py-2">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                class="text-blue-600 text-sm md:text-base hover:underline">
                                                編集
                                            </a>

                                            <form action="{{ route('admin.articles.destroy', $article->id) }}"
                                                method="POST" onsubmit="return confirm('この記事を削除してもよろしいですか？');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 text-sm md:text-base hover:underline">
                                                    削除
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="border px-2 md:px-4 py-2">
                                        @if ($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                alt="{{ $article->title }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <span class="text-xs text-gray-400">なし</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                                        記事がまだ登録されていません。
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
