<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タグ管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">タグ一覧</h1>

                    <a href="{{ route('admin.tags.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                        タグを追加
                    </a>
                </div>

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded px-3 py-2">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm md:text-base">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-2 md:px-4 py-2 w-1/2 text-left">名前</th>
                                <th class="border px-2 md:px-4 py-2 w-1/2 text-left">スラッグ</th>
                                <th class="border px-2 md:px-4 py-2 text-left">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $tag->name }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $tag->slug }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                                class="text-blue-600 text-sm md:text-base hover:underline">
                                                編集
                                            </a>

                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                                onsubmit="return confirm('このタグを削除してもよろしいですか？');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 text-sm md:text-base hover:underline">
                                                    削除
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border px-4 py-4 text-center text-gray-500">
                                        タグがまだ登録されていません。
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
