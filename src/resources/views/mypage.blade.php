@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
    </form>

    <a href="{{ route('mypage') }}">マイページ</a>
    <a href="{{ route('sell') }}">出品</a>
</header>

<!-- マイページ ユーザー情報 -->
<div class="mypage-user">
    <!-- 左：ユーザー画像 -->
    <div class="mypage-user__image">
        <img
            src="{{ asset('storage/users/' . Auth::user()->image) }}"
            alt="ユーザー画像">
    </div>

    <!-- 中央：ユーザー名 -->
    <div class="mypage-user__name">
        {{ Auth::user()->name }}
    </div>

    <!-- 右：プロフィール編集ボタン -->
    <div class="mypage-user__edit">
        <a href="{{ route('profile.edit') }}" class="edit-button">
            プロフィールを編集
        </a>
    </div>
</div>

<!-- 見出し -->
<div class="tab">
    <h2 class="tab__item tab__item--active">出品した商品</h2>
    <h2 class="tab__item">購入した商品</h2>
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