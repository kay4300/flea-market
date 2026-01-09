@extends('layouts.app')

@section('title', 'メール認証 | Flea Market')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mailenable.css') }}">
@endsection

@section('content')

<div class="verify">

    <p class="verify__text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <div class="verify__button-wrapper">
        <a href="{{ route('makeprofile') }}" class="verify__button">
            認証はこちらから
        </a>
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