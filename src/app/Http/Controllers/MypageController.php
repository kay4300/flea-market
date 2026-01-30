<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    public function index()
    {
        // マイページ表示
        $user = Auth::user();

        // ログインユーザーが出品した商品
        $items = Item::where('user_id', $user->id)->get();

        return view('mypage', compact('items'));
    }
    //
}
