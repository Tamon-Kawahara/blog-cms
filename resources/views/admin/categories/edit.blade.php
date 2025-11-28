<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Edit Category</h1>

                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                            class="w-full rounded border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Slug <span class="text-xs text-gray-500">(empty = auto generate)</span>
                        </label>
                        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                            class="w-full rounded border-gray-300 shadow-sm">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.categories.index') }}"
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
