<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Articles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Articles</h1>

                    <a href="{{ route('admin.articles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Create New Article
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm md:text-base">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-2 md:px-4 py-2">Title</th>
                                <th class="border px-2 md:px-4 py-2">Category</th>
                                <th class="border px-2 md:px-4 py-2">Tags</th>
                                <th class="border px-2 md:px-4 py-2">Status</th>
                                <th class="border px-2 md:px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $article->title }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $article->category->name ?? '-' }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        @foreach ($article->tags as $tag)
                                            <span
                                                class="inline-block text-xs md:text-sm bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $article->status }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        <div class="flex item-center gap-3">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                class="text-blue-600 text-sm md:text-base hover:underline">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.articles.destroy', $article->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this article');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 text-sm md:text-base hover:underline">Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($articles->isEmpty())
                                <tr>
                                    <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                                        No articles yet.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
