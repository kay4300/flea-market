<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class LoginController extends Controller
{
    // ログインフォーム表示
    public function showLoginForm()
    {
        return view('login'); // login.blade.php を表示
    }
    // ログイン処理
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // 認証成功
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // セキュリティ用にセッション再生成

            $user = Auth::user();

            // メール未認証ならメール認証誘導画面へ
            if (! $user->hasVerifiedEmail()) {
                return redirect()->route('mailenable');
            }

            // 認証済みならプロフィールチェック
            $profile = $user->profile;

            if (!$profile || empty($profile->name) || empty($profile->address)) {
                return redirect()->route('makeprofile.create');
            }

            // プロフィール登録済みならindex画面へ
            return redirect()->route('index.afterlogin'); // index.blade.php に遷移
        }
        // 認証失敗
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->withInput();
    }
}
