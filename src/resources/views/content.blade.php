@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/content.css') }}">
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

<div class="product-detail">

    <!-- 左右2分割 -->
    <div class="product-detail__left">
        <!-- 左上：商品画像 -->
        <div class="product-image">
            <img src="{{ asset('storage/items/' . $item->image) }}" alt="{{ $item->name }}">
        </div>

        <!-- 左下：何も表示しない -->
        <div class="product-image__empty"></div>
    </div>

    <div class="product-detail__right">

        <!-- 商品名 -->
        <h1 class="product-name">{{ $item->name }}</h1>

        <!-- ブランド名 -->
        <p class="product-brand">{{ $item->brand }}</p>

        <!-- 金額 -->
        <p class="product-price">￥{{ number_format($item->price) }}（税込）</p>

        <!-- いいね・コメント -->
        <div class="reaction">
            <div class="reaction__item">
                <span class="reaction__icon">♥</span>
                <span class="reaction__count">{{ $item->likes_count }}</span>
            </div>

            <div class="reaction__item">
                <span class="reaction__icon">💬</span>
                <span class="reaction__count">{{ $item->comments_count }}</span>
            </div>
        </div>

        <!-- 購入ボタン -->
        <button class="purchase-button">購入手続きへ</button>

        <!-- 商品説明 -->
        <h2 class="section-title">商品説明</h2>

        <div class="product-info">
            <div class="info-row">
                <span class="info-label">カラー</span>
                <span class="info-value">{{ $item->color }}</span>
            </div>

            <p class="info-text">{{ $item->condition_description }}</p>
            <p class="info-text">{{ $item->shipping_description }}</p>
        </div>

        <!-- 商品情報 -->
        <h2 class="section-title">商品情報</h2>

        <div class="product-info">
            <div class="info-row">
                <span class="info-label">カテゴリー</span>
                <div class="category-list">
                    @foreach ($item->categories as $category)
                    <span class="category-item">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="info-row">
                <span class="info-label">商品の状態</span>
                <span class="info-value">{{ $item->status }}</span>
            </div>
        </div>

        <!-- コメント一覧 -->
        <h2 class="section-title">コメント（{{ $item->comments->count() }}）</h2>

        @foreach ($item->comments as $comment)
        <div class="comment">
            <div class="comment-user">
                <img
                    src="{{ asset('storage/profile/' . $comment->user->profile_image) }}"
                    alt="ユーザー画像"
                    class="comment-user__image">
                <span class="comment-user__name">{{ $comment->user->name }}</span>
            </div>

            <p class="comment-text">{{ $comment->body }}</p>
        </div>
        @endforeach

        <!-- コメント投稿 -->
        <h2 class="section-title">商品へのコメント</h2>

        <form method="POST" action="#">
            @csrf
            <textarea
                name="comment"
                maxlength="255"
                placeholder="255文字以内で入力してください"
                class="comment-textarea">
            </textarea>
            <div class="form__error">
                @error('comment')
                {{ $message }}
                @enderror
            </div>

            <button type="submit" class="comment-submit">
                コメントを送信する
            </button>
        </form>

    </div>
</div>