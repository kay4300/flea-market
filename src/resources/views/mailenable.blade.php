@extends('layouts.app')

@section('title', 'メール認証 | Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mailenable.css') }}">
@endsection

@section('content')

<div class="verify">

    @if (session('status') == 'verification-link-sent')
    <p style="color: green;">
        認証を確認しました
    </p>
    @endif

    <p>
        登録したメールアドレスに認証メールを送信しました。<br>
        メール内のリンクをクリックしてください。
    </p>
    <!-- <p class="verify__text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください.
    </p> -->

    <div class="verify__button-wrapper">
        <!-- <a href="{{ route('verification.notice') }}" class="verify__button"> -->
        <!-- メール認証済みかどうかに関係なくトップページに飛ぶ -->
        <!-- <a href="{{ route('top', ['tab' => 'mylist']) }}" class="verify__button">
         -->
        <!-- 認証はこちらから
        </a> -->

        <!-- 認証済みテスト用フォーム送信 -->
        <form method="POST" action="{{ route('verified.redirect') }}">
            @csrf
            <button type="submit" class="verify__button">
                認証はこちらから（テスト用）
            </button>
        </form>
    </div>

    <div class="verify__resend">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify__resend-link">
                認証メールを再送する
            </button>
        </form>
    </div>

</div>

@endsection