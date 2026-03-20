<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'Flea Market')</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>

    <header class="header">
        <div class="header__inner">
            <div class="header__logo">COACHTECH</div>

            @php
            $isGuestTop = Route::currentRouteName() === 'top' && !auth()->check();
            @endphp

            <!-- 未ログインのトップページ専用 -->
            @if($isGuestTop)
            <div class="header__left">
                <input
                    type="text"
                    class="header__search"
                    placeholder="何をお探しですか？">
            </div>

            <form action="{{ route('login') }}" method="GET">
                @csrf
                <button type="submit">ログイン</button>
            </form>
            @endif

            <!-- 検索バー（全ページ共通なら中央、特定ページだけ表示可） -->
            {{-- @unless(in_array(Route::currentRouteName(), ['login', 'register', 'mailenable', 'mailverification'])) --}}
            @unless(
            in_array(Route::currentRouteName(), ['login', 'register', 'mailenable', 'mailverification'])
            || (Route::currentRouteName() === 'top' && !auth()->check())
            )
            <div class="header__search-wrapper">
                <form action="{{ route('index.afterlogin') }}" method="GET">
                    <input type="text" name="keyword" class="header__search" placeholder="何をお探しですか？" value="{{ request('keyword') }}">
                    <button type="submit" style="display:none;"></button>
                </form>
            </div>
            @endunless
            
            <!-- 右側ナビは特定ページのみ表示 -->
            @if(
            !in_array(Route::currentRouteName(), ['login', 'register', 'mailenable', 'mailverification'])
            && !(Route::currentRouteName() === 'top' && !auth()->check())
            )
            <div class="header__nav">
                <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>

                <a href="{{ route('mypage') }}" class="header__link">マイページ</a>
                <a href="{{ route('sell') }}" class="header__link-sell">出品</a>
            </div>
            @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>