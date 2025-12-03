<aside class="mt-8 lg:mt-0 lg:w-64 space-y-6">
    {{-- 検索フォーム --}}
    <section class="bg-white rounded-lg shadow-sm p-4">
        <h2 class="text-sm font-semibold mb-3 border-l-4 border-blue-500 pl-2">
            検索
        </h2>

        <form method="GET" action="{{ route('articles.index') }}" class="space-y-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="キーワードを入力"
                class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            {{-- Enterで送信でもいいけど、ボタンも一応用意 --}}
            <button type="submit"
                class="w-full inline-flex justify-center px-3 py-2 text-xs font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700">
                検索
            </button>
        </form>
    </section>
    {{-- カテゴリ一覧 --}}
    @isset($categories)
        <section class="bg-white rounded-lg shadow-sm p-4">
            <h2 class="text-sm font-semibold mb-3 border-l-4 border-blue-500 pl-2">
                カテゴリー
            </h2>

            <ul class="space-y-1 text-sm">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('articles.byCategory', $category) }}"
                            class="flex items-center justify-between text-gray-700 hover:text-blue-600">
                            <span>{{ $category->name }}</span>
                            {{-- @if (isset($category->articles_count))
                                <span class="text-xs text-gray-400">
                                    {{ $category->articles_count }}
                                </span>
                            @endif --}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endisset

    {{-- 最近の記事 --}}
    @isset($recentArticles)
        <section class="bg-white rounded-lg shadow-sm p-4">
            <h2 class="text-sm font-semibold mb-3 border-l-4 border-blue-500 pl-2">
                最近の記事
            </h2>

            <ul class="space-y-2 text-sm">
                @foreach ($recentArticles as $recent)
                    <li>
                        <a href="{{ route('articles.show', $recent) }}" class="block text-gray-700 hover:text-blue-600">
                            <span class="block text-xs text-gray-400">
                                {{ optional($recent->published_at)->format('Y-m-d') }}
                            </span>
                            <span class="line-clamp-2">
                                {{ $recent->title }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endisset

    {{-- バナーエリア（ダミー）
    <section class="bg-white rounded-lg shadow-sm p-4">
        <div class="h-32 flex items-center justify-center text-xs text-gray-500 text-center">
            バナーや資料DLのリンクなど<br>あとで差し替える用エリア
        </div>
    </section> --}}
</aside>
