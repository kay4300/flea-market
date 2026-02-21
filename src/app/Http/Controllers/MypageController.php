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
    // 全商品を取得（購入済みかどうかは関係なし）
    $items = Item::all();
        $tab = 'all';

        // index.blade.php に渡す
        return view('index', compact('items', 'tab'));
    }
    // マイページ表示
    //     $user = Auth::user();

    //     // ログインユーザーが出品した商品
    //     $sellItems = Item::where('user_id', $user->id)->get();

    //     return view('mypage', compact('sellItems'));
    // }

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

        if ($item->is_sold) {
            return back()->with('error', 'この商品はすでに売り切れです');
        }

        $item->is_sold = true;
        $item->buyer_id = auth()->id();
        $item->save();

        return redirect()->route('mypage');
    }

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
