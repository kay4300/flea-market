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

    <div class="verify__button-wrapper">
        <!-- 認証済みフォーム送信 -->
        <a href="{{ URL::signedRoute('after.verify') }}" >
            認証はこちらから
        </a>
        <!-- <form method="POST" action="{{ route('verified.redirect') }}">
            @csrf
            <button type="submit" class="verify__button">
                認証はこちらから
            </button>
        </form> -->
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