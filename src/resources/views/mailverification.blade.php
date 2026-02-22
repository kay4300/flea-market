@extends('layouts.app')

@section('title', 'メール認証 | Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mailverification.css') }}">
@endsection

@section('content')

<div class="container">
    <h2>メール認証完了</h2>

    <a href="{{ route('makeprofile.create') }}" class="btn btn-primary">
        プロフィール作成へ
    </a>
</div>