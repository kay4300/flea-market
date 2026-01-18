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
    <form class="form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品画像</span>
            </div>
            <!-- 商品の画像を選択して表示 -->
            <div class="form__group-content">
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form__error">
                @error('image')
                {{ $message }}
                @enderror
            </div>
        </div>

        <h2 class="section-title">商品の詳細</h2>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">カテゴリー</span>
            </div>
            @php
            $categories = [
            'ファッション', '家電', 'インテリア', 'レディース', 'メンズ',
            'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン',
            'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'
            ];
            $selectedCategories = old('categories', []);
            @endphp

            <div class="category-select">
                @foreach ($categories as $index => $category)
                <input
                    type="checkbox"
                    id="category_{{ $index }}"
                    name="categories[]"
                    value="{{ $category }}"
                    {{ in_array($category, $selectedCategories) ? 'checked' : '' }}
                    class="category-checkbox">
                <label for="category_{{ $index }}" class="category-label">
                    {{ $category }}
                </label>
                @endforeach
            </div>

        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の状態</span>
            </div>
            <select name="condition" id="condition">
                <option value="">選択してください</option>
                <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                <option value="目立ったキズや汚れなし" {{ old('condition') == '目立ったキズや汚れなし' ? 'selected' : '' }}>目立ったキズや汚れなし</option>
                <option value="ややキズや汚れあり" {{ old('condition') == 'ややキズや汚れあり' ? 'selected' : '' }}>ややキズや汚れあり</option>
                <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>

            @error('condition')
            <div class="form__error">{{ $message }}</div>
            @enderror
        </div>

        <h2 class="section-title">商品名と説明</h2>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="item" value="{{ old('item') }}" required>
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
                class="comment-textarea">{{ old('comment') }}</textarea>
            </textarea>
            <div class="form__error">
                @error('comment')
                {{ $message }}
                @enderror
            </div>

        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">販売価格</span>
            </div>
            < class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="price" value="{{ old('price') }}" required>
                </div>
                <div class="form__error">
                    @error('price')
                    {{ $message }}
                    @enderror
                </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>