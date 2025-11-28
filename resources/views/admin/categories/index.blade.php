<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Categories</h1>

                    <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Create New Category
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
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $category->name }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="border px-2 md:px-4 py-2">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="text-blue-600 text-sm md:text-base hover:underline">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this category?');"
                                                class="inline">
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

                            @if ($categories->isEmpty())
                                <tr>
                                    <td colspan="3" class="border px-4 py-4 text-center text-gray-500">
                                        No categories yet.
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
