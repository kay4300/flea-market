<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 登録フォームを表示
    public function create()
    {
        return view('register');
    }

    // 登録処理
    public function store(RegisterRequest $request)
    {
        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 登録後ログイン
        Auth::login($user);

        // メール認証ページへリダイレクト
        return redirect()->route('mailenable');
    }

    // ログインフォーム表示
    public function showLoginForm()
    {
        return view('login'); // login.blade.php を表示
    }
    // ログイン処理
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // ログイン認証成功
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // セキュリティ用にセッション再生成
            return redirect()->route('items.index'); // index.blade.php に遷移
        }
        
        // ログイン認証失敗
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->withInput();
    }
}
