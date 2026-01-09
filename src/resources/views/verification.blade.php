@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verification.css') }}">
@endsection

@section('content')

<div class="verification__container">
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">COACHTECH</a>
        </div>
    </header>

    <main>
        <div class="verification__content">
            <div class="verify__text">
                認証コードを入力してください
            </div>

            <!-- 6桁コード入力 -->
            <form method="POST" action="{{ route('verification') }}">
                @csrf
                <div class="verify__code-input">
                    <input type="text" name="verification_code" maxlength="6" placeholder="●●●●●●" required>
                </div>

                <div class="verify__button-wrapper">
                    <button type="submit" class="verify__button">
                        認証する
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

@endsection