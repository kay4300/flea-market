@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fleamarket.css') }}">
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
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <button type="submit">ログイン</button>
    </form>

    <a href="{{ route('mypage') }}">マイページ</a>
    <a href="{{ route('sell') }}">出品</a>
</header>

<!-- 見出し（おすすめ・マイリスト） -->
<div class="tab">
    <h2 class="tab__item tab__item--active">おすすめ</h2>
    <h2 class="tab__item">マイリスト</h2>
</div>

<!-- 商品一覧 -->
<div class="item-list">
    @foreach ($items as $item)
    <div class="item-card">
        <a href="{{ route('items.show', $item->id) }}">
            <img
                src="{{ $item->image) }}"
                alt="{{ $item->name }}"
                class="item-card__image">
            <p class="item-card__name">{{ $item->name }}</p>
        </a>
    </div>
    @endforeach
</div>