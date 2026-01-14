<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MakeProfileRequest;
use App\Models\User;
use App\Models\Profile;

class MakeProfileController extends Controller
{
    // プロフィール編集画面表示
    public function create()
    {
        $user = Auth::user();

        // 既存プロフィールがあれば取得、なければ新規作成用の空オブジェクト
        $profile = Profile::firstOrNew([
            'user_id' => $user->id
        ]);

        return view('makeprofile', compact('profile'));
    }
    // プロフィール更新
    public function store(MakeProfileRequest $request)
    {
        $user = Auth::user();
        // dd($user);

        // // users テーブル更新
        // $user->name = $request->name;
        // $user->save();

        // 既存プロフィールがあれば取得、なければ新規作成
        $profile = Profile::firstOrNew([
            'user_id' => $user->id,
        ]);

        $profile->user_id  = $user->id;
        $profile->name     = $request->name;
        $profile->postcode = $request->postcode;
        $profile->address  = $request->address;
        $profile->building = $request->building;

       
        // 画像があれば保存
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile', $filename);

            $profile->profile_image = $filename;

            // $image->move(public_path('uploads/profile'), $filename);
            // $user->profile_image = $filename;
        }

        $profile->save();

        // 商品一覧ページへリダイレクト
        return redirect()->route('items.index');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();

        // invalidate()でセッションを無効化。regenerateToken()で@csrf対策。
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログイン画面へリダイレクト
        return redirect()->route('login');
    }
}
    //
