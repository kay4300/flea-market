<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

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
            return redirect()->route('items.index'); // index.blade.php に遷移
        }

        // 認証失敗
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->withInput();
    }
}
