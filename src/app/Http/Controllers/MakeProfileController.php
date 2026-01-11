<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MakeProfileRequest;
use App\Models\User;
use App\Models\Profile;

class MakeProfileController extends Controller
{
    // プロフィール更新
    public function update(MakeProfileRequest $request)
    {
        $user = Auth::user();

        // フォームリクエストでバリデーション済みなのでここでは不要
        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        // 画像があれば保存
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile'), $filename);
            $user->profile_image = $filename;
        }

        $profile->save();

        // 商品一覧ページへリダイレクト
        return redirect()->route('items.index');
    }

    public function logout(Request $request)
    {
        // ログアウト処理
        Auth::logout();

        // invalidate()でセッションを無効化。regenerateToken()で@csrf対策。
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログイン画面へリダイレクト
        return redirect()->route('login');
    }
}
    //