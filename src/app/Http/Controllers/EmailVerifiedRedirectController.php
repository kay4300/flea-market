<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailVerifiedRedirectController extends Controller
{

    public function redirect()
    {
        $user = Auth::user();

        // // プロフィールが存在すればトップページへ
        // if ($user->profile) {
        //     return redirect()->route('top');
        // }

        // // プロフィールがなければ作成ページへ
        // return redirect()->route('makeprofile.create');
        // ① Eloquent（profilesテーブル）
        if ($user->profile) {
            return redirect()->route('index.afterlogin');
        }

        // ② create_profile_table を直接確認
        $profileExists = DB::table('create_profile_table')
            ->where('user_id', $user->id)
            ->exists();

        if ($profileExists) {
            return redirect()->route('index.afterlogin');
        }

        // ③ どちらも無ければプロフィール作成
        return redirect()->route('makeprofile.create');
    }

    
}
    //

