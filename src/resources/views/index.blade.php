@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<!-- ヘッダー -->
<header class="header">
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
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
    </form>

    <a href="{{ route('mypage') }}">マイページ</a>
    <a href="{{ route('sell') }}">出品</a>
</header>

<!-- 見出し（おすすめ・マイリスト） -->
<div class="tab">
    <a href="{{ route('index.afterlogin', ['tab' => 'recommend']) }}"
        class="tab__item {{ request('tab', 'recommend') === 'recommend' ? 'tab__item--active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('index.afterlogin', ['tab' => 'wishlist']) }}"
        class="tab__item {{ request('tab') === 'wishlist' ? 'tab__item--active' : '' }}">
        マイリスト
    </a>
</div>

<!-- 商品一覧 -->
<div class="item-list">
    @foreach ($items as $item)
    <div class="item-card">
        @if($item->is_sold)
        <span class="sold-label">sold</span>
        @endif
        <a href="{{ route('items.show', $item->id) }}">
            <img
                src="{{ $item->image }}"
                alt="{{ $item->name }}"
                class="item-card__image">
            <p class="item-card__name">{{ $item->name }}</p>
        </a>
    </div>
    @endforeach
</div>

<div class="pagination">
    {{ $items->appends(['tab' => $tab])->links() }}
</div>