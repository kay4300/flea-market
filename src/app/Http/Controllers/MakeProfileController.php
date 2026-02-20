<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MakeProfileRequest;
use App\Models\User;
use App\Models\Profile;

class MakeProfileController extends Controller
{
    // プロフィール編集画面表示
    public function create()
    {
        $profile = Auth::user()->profile ?? new Profile();
        return view('makeprofile', compact('profile'));
    }

    //     // 既存プロフィールがあれば取得、なければ新規作成用の空オブジェクト
    //     $profile = Profile::firstOrNew([
    //         'user_id' => $user->id
    //     ]);

    //     return view('makeprofile', compact('profile'));
    // }
    // プロフィール更新
    public function store(MakeProfileRequest $request)
    {
        $user = Auth::user();
        // 既存プロフィールを取得、なければ新規作成
        $profile = Profile::firstOrNew(['user_id' => $user->id]);
        // $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->name     = $request->name;
        $profile->postcode = $request->postcode;
        $profile->address  = $request->address;
        $profile->building = $request->building;

        // 画像があれば保存
        if ($request->hasFile('profile_image')) {
             $path= $request->file('profile_image')->store('profiles', 'public');
             $profile->profile_image = $path;
        }

        $profile->save();

        // 商品一覧ページへリダイレクト
        return redirect()->route('index.afterlogin');
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

    // 編集画面表示
    public function edit()
    {
        $profile = Auth::user()->profile ?? new Profile();
        
            return view('profile', compact('profile'));
        
    }

    // プロフィール更新処理
    public function update(MakeProfileRequest $request)
    {
        $user = Auth::user();

        $profile = Profile::where(
            'user_id',
            $user->id
        )->firstOrFail();
        // 画像がアップロードされた場合
        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            $path = $request->file('profile_image')->store('profiles', 'public');
            $profile->profile_image = $path;
        }

        $profile->update([
            'name'     => $request->name,
            'postcode' => $request->postcode,
            'address'  => $request->address,
            'building' => $request->building,
        ]);
        return redirect()
            ->route('mypage')
            ->with('success', 'プロフィールを更新しました。');
    }
}
