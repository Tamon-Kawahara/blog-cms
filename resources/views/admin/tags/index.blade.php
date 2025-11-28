<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tags
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Tags</h1>

                    <a href="{{ route('admin.tags.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Create New Tag
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
                                <th class="border px-2 md:px-4 py-2 w-1/2">Name</th>
                                <th class="border px-2 md:px-4 py-2 w-1/2">Slug</th>
                                <th class="border px-2 md:px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
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
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this tag?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 text-sm md:text-base hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($tags->isEmpty())
                                <tr>
                                    <td colspan="3" class="border px-4 py-4 text-center text-gray-500">
                                        No tags yet.
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
