@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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

<div class="register-form__content">
    <div class="register-form__heading">
        <h1>商品の出品</h1>
    </div>

    <!-- action="/register"→登録処理用のルートに送信 -->
    <form class="form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品画像</span>
            </div>
        </div>
        <h2 class="section-title">商品の詳細</h2>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">カテゴリー</span>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の状態</span>
            </div>
            <select id="condition">
                <option value="">""</option>
                <option value="良好">良好</option>
                <option value="目立ったキズや汚れなし">目立ったキズや汚れなし</option>
                <option value="ややキズや汚れあり">ややキズや汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>


            <h2 class="section-title">商品名と説明</h2>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">商品名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="item" value="{{ old('item') }}" />
                    </div>
                    <div class="form__error">
                        @error('item')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">ブランド名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="brand" value="{{ old('brand') }}" />
                    </div>
                    <div class="form__error">
                        @error('brand')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">商品の説明</span>
                </div>
                <textarea
                    name="comment"
                    maxlength="120"
                    placeholder="120文字以内で入力してください"
                    class="comment-textarea"></textarea>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">販売価格</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="price" />
                    </div>
                    <div class="form__error">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">出品する</button>
            </div>
    </form>
</div>