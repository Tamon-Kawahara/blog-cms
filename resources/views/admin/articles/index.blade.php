<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Articles</h1>

    <a href="{{ route('admin.articles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        Create New Article
    </a>

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
                    <tr>
                        <td class="border px-2 md:px-4 py-2">{{ $article->title }}</td>
                        <td class="border px-2 md:px-4 py-2">
                            {{ $article->category->name ?? '-' }}
                        </td>
                        <td class="border px-2 md:px-4 py-2">
                            @foreach ($article->tags as $tag)
                                <span class="inline-block text-xs md:text-sm bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="border px-2 md:px-4 py-2">
                            {{ $article->status }}
                        </td>
                        <td class="border px-2 md:px-4 py-2">
                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                class="text-blue-600 underline text-sm md:text-base">
                                Edit
                            </a>
                        </td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
