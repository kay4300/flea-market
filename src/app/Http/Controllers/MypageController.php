<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Profile;

class MypageController extends Controller
{
    // public function index()
    // {
    //     // 出品商品を取得
    //     $items = Item::where('user_id', auth()->id())->get();
    //     $tab = 'sell';

    //     // index.blade.php に渡す
    //     return view('mypage', compact('items', 'tab'));
    // }
    // マイページ表示
    //     $user = Auth::user();

    //     // ログインユーザーが出品した商品
    //     $sellItems = Item::where('user_id', $user->id)->get();

    //     return view('mypage', compact('sellItems'));
    // }

    // 購入済み商品の表示
    public function mypage()
    {
        $userId = auth()->id();

        // 購入済み商品
        $purchasedItems = Item::where('buyer_id', $userId)->get();

        // 出品した商品
        $sellItems = Item::where('user_id', $userId)->get();

        // Bladeに両方渡す
        return view('mypage', compact('purchasedItems', 'sellItems'));
    
    }

    public function store(Request $request)
    {
        // 購入処理を書く

        return redirect()->route('mypage');
    }


    // 住所変更画面表示
    public function editAddress()
    {
        return view('address_edit');
    }


    //
}
