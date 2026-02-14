<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Profile;

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

    // 購入画面表示
    public function show($itemId)
    {
        // 購入対象商品を取得
        $item = Item::findOrFail($itemId);
        // ログインユーザーのプロフィールを取得
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();

        return view('purchase', compact('item', 'profile'));
    }

    public function purchase($id)
    {
        $item = Item::findOrFail($id);

        $item->is_sold = true;
        $item->buyer_id = auth()->id();
        $item->save();

        return redirect()->route('index.afterlogin');
    }

    // 購入済み商品の表示
    public function mypage()
    {
        $purchasedItems = Item::where('buyer_id', auth()->id())->get();

        return view('mypage', compact('purchasedItems'));
    }

    public function store(Request $request)
    {
        // 購入処理を書く

        return redirect()->route('index.afterlogin');
    }


    // 住所変更画面表示
    public function editAddress()
    {
        return view('address_edit');
    }


    //
}
