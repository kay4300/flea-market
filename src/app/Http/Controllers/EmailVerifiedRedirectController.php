<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EmailVerifiedRedirectController extends Controller
{

    public function redirect()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // プロフィールが存在しない OR 必須項目が空なら作成ページへ
        if (!$profile || empty($profile->name) || empty($profile->address)) {
            return redirect()->route('makeprofile.create');
        }
        // あれば通常のトップへ
        return redirect()->route('index.afterlogin');
    }
        
        // // プロフィールがなければ作成ページへ
        // return redirect()->route('makeprofile.create');
        // ① Eloquent（profilesテーブル）
        // if ($user->profile) {
        //     return redirect()->route('index.afterlogin');
        // }

        // // ② create_profile_table を直接確認
        // $profileExists = DB::table('create_profile_table')
        //     ->where('user_id', $user->id)
        //     ->exists();

        // if ($profileExists) {
        //     return redirect()->route('index.afterlogin');
        // }

        // ③ どちらも無ければプロフィール作成
        // return redirect()->route('makeprofile.create');
}

    

    //

