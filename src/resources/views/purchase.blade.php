@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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

<div class="purchase-container">

    {{-- 左エリア --}}
    <div class="purchase-left">

        {{-- 商品情報 --}}
        <div class="product-row">
            <div class="product-image">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
            </div>

            <div class="product-detail">
                <p class="product-name">{{ $item->name }}</p>
                <p class="product-price">¥ {{ number_format($item->price) }}</p>
            </div>
        </div>

        <hr>

        {{-- 支払方法 --}}
        <div class="payment-area">
            <h3>支払い方法</h3>
            <select id="paymentSelect">
                <option value="">選択してください</option>
                <option value="クレジット払い">クレジット払い</option>
                <option value="コンビニ払い">コンビニ払い</option>
            </select>
        </div>

        <hr>

        {{-- 配送先 --}}
        <div class="address-area">
            <div class="address-header">
                <h3>配送先</h3>
                <a href="{{ route('address.edit') }}" class="change-link">変更する</a>
            </div>

            <p>〒{{ $profile->postcode }}</p>
            <p>{{ $profile->address }}</p>
        </div>

        <hr>
    </div>

    {{-- 右エリア --}}
    <div class="purchase-right">

        <div class="summary-box">

            <div class="summary-row">
                <span>商品代金</span>
                <span>¥ {{ number_format($item->price) }}</span>
            </div>

            <div class="summary-row">
                <span>支払い方法</span>
                <span id="paymentResult">未選択</span>
            </div>

        </div>

        <form action="{{ route('thanks') }}" method="GET">
            <button class="purchase-button">購入する</button>
        </form>

    </div>

</div>

{{-- 支払方法連動 --}}
<script>
    const select = document.getElementById('paymentSelect');
    const result = document.getElementById('paymentResult');

    select.addEventListener('change', () => {
        result.textContent = select.value || '未選択';
    });
</script>