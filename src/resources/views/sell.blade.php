@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')

<div class="register-form__content">
    <div class="register-form__heading">
        <h1>商品の出品</h1>
    </div>

    <!-- action="/register"→登録処理用のルートに送信 -->
    <form class="form" method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品画像</span>
            </div>
            <!-- 商品の画像を選択して表示 -->
            <div class="form__image-wrapper">
                <img src="{{ asset('images/no-image.png') }}" alt="" class="form__image-preview">
                <label for="image" class="form__image-button">画像を選択</label>
                <input type="file" name="image" id="image" accept="image/*" hidden>
            </div>

        </div>
        <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
        </div>

        <h2 class="section-title">商品の詳細</h2>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">カテゴリー</span>
            </div>
        </div>
        
        @php
        $allCategories = \App\Models\Category::all();
        $selectedCategories = old('categories', []);
        @endphp

        <div class="category-select">
            @foreach ($allCategories as $index => $category)
            <input type="checkbox" id="category_{{ $category->id }}" name="categories[]"
                value="{{ $category->id }}"
                {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                class="category-checkbox">
            <label for="category_{{ $category->id }}" class="category-label">
                {{ $category->name }}
            </label>
            @endforeach
            <div class="form__error">
                @error('categories')
                {{ $message }}
                @enderror
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
            <div class="form__error">
                @error('condition')
                {{ $message }}
                @enderror
            </div>
        </div>

        <h2 class="section-title">商品名と説明</h2>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
            </div>
        </div>
        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">ブランド名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="brand" value="{{ old('brand') }}" />
                </div>
            </div>
        </div>
        <div class="form__error">
            @error('brand')
            {{ $message }}
            @enderror
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の説明</span>
            </div>
            <div class="form__group-content">
                <textarea name="comment" maxlength="120" placeholder="120文字以内で入力してください"
                    class="comment-textarea">{{ old('comment') }}</textarea>
            </div>
        </div>
        <div class="form__error">
            @error('comment')
            {{ $message }}
            @enderror
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">販売価格</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="price" value="{{ old('price') }}" required>
                </div>
            </div>
        </div>
        <div class="form__error">
            @error('price')
            {{ $message }}
            @enderror
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>

@endsection