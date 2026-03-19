@extends('layouts.app')

@section('title', 'Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')

<div class="pagination-wrapper">
    {{ $items->appends(['tab' => $tab])->links() }}
</div>

<!-- 見出し（おすすめ・マイリスト） -->
<div class="tab">
    <a href="{{ route('index.afterlogin', ['tab' => 'recommend']) }}"
        class="tab__item {{ request('tab', 'recommend') === 'recommend' ? 'tab__item--active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('index.afterlogin', ['tab' => 'wishlist', 'keyword' => request('keyword')]) }}"
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

<!-- <div class="pagination-wrapper">
    {{ $items->appends(['tab' => $tab])->links() }}
</div> -->

@endsection