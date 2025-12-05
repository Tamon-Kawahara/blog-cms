<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- 左側 --}}
            <div class="flex">
                {{-- ロゴ --}}
                <div class="flex-shrink-0 flex items-center">
                    @if (request()->routeIs('dashboard') || request()->routeIs('admin.*'))
                        {{-- 管理画面モード：ダッシュボードへ --}}
                        <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-gray-800">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    @else
                        {{-- 公開モード：トップへ --}}
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    @endif
                </div>

                {{-- メインリンク（デスクトップ） --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (request()->routeIs('dashboard') || request()->routeIs('admin.*'))
                        {{-- ★ 管理画面用ナビ --}}
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                  {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            ダッシュボード
                        </a>

                        <a href="{{ route('admin.articles.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                  {{ request()->routeIs('admin.articles.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            記事管理
                        </a>
                    @else
                        {{-- ★ 公開側は基本リンクなし（シンプルに） --}}
                        {{-- 必要なら「記事一覧」とか追加してもOK --}}
                    @endif
                </div>
            </div>

            {{-- 右側：公開/管理で出し分け --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                @if (request()->routeIs('dashboard') || request()->routeIs('admin.*'))
                    {{-- 管理画面モード：公開サイトへのリンク --}}
                    <a href="{{ url('/') }}" target="_blank"
                        class="text-sm text-gray-600 hover:text-gray-900 border border-gray-200 px-3 py-1.5 rounded-md bg-white hover:bg-gray-50">
                        公開サイトを見る
                    </a>
                @else
                    {{-- 公開モード：ログイン中はダッシュボードへのリンク --}}
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            管理画面へ
                        </a>
                    @endauth
                @endif

                {{-- プロフィールドロップダウン（両方で共通） --}}
                @auth
                    <div class="relative" x-data="{ openMenu: false }">
                        <button @click="openMenu = !openMenu"
                            class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                            <span class="mr-1">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="openMenu" @click.away="openMenu = false" x-transition
                            class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1 text-sm text-gray-700">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    プロフィール
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                        ログアウト
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- ハンバーガー（モバイル） --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- モバイルメニュー --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @if (request()->routeIs('dashboard') || request()->routeIs('admin.*'))
                {{-- 管理モード --}}
                <a href="{{ route('dashboard') }}"
                    class="block pl-3 pr-4 py-2 text-base font-medium
                          {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    ダッシュボード
                </a>

                <a href="{{ route('admin.articles.index') }}"
                    class="block pl-3 pr-4 py-2 text-base font-medium
                          {{ request()->routeIs('admin.articles.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    記事管理
                </a>

                <a href="{{ url('/') }}"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                    公開サイトを見る
                </a>
            @else
                {{-- 公開モード --}}
                <a href="{{ url('/') }}"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                    トップ
                </a>

                @auth
                    <a href="{{ route('dashboard') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        管理画面へ
                    </a>
                @endauth
            @endif
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        プロフィール
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
