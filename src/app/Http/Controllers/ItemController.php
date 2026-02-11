<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Content2Request;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // デフォルト: おすすめ

        if (!Auth::check()) {
            // 未ログイン → おすすめのみ表示
            $items = Item::latest()->paginate(7);
            return view('index', compact('items', 'tab'));
        }

        // ログイン済み
        if ($tab === 'recommend') {
            $items = Item::latest()->paginate(7);
        } elseif ($tab === 'wishlist') {
            $user = Auth::user();
            // いいねした商品のみ取得（pivotテーブルやlikesテーブル想定）
            $items = $user->likedItems()->latest()->paginate(7);
        } else {
            $items = Item::latest()->paginate(7);
        }

        return view('index', compact('items', 'tab'));
        // 未ログイン → ログイン前トップ
        // if (!Auth::check()) {
        //     $items = Item::latest()->paginate(7);
        //     return view('fleamarket', compact('items'));
        // }

        // ログイン済・未認証 → Fortifyの認証案内
        // if (! $request->user()->hasVerifiedEmail()) {
        //     return redirect()->route('verification.notice');
        // }

        // ログイン済・認証済 → ログイン後トップ
        // $tab = $request->query('tab', 'recommend');

        // // ログイン済・認証済 → ログイン後トップ
        // $items = Item::latest()->take(3)->get();
        // $tab = $request->query('tab', 'recommend'); // tabパラメータの取得

        // return view('index', compact('items', 'tab'));

        // return redirect()->route('index.afterlogin', ['items' => $tab]);
    }

    // 商品詳細画面
    // URLの {item} と自動で紐づく
    public function show(Item $item)
    {
        // eager loadingでcommentsとusersの情報をまとめて取得。$item->comments→ commentテーブルのデータ    
        $item->load(['user', 'categories','comments.user']);

        return view('content', compact('item'));
    }
    // 未ログイン画面からコメント送信したときのエラー処理
    public function store(Content2Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors(['comment' => 'コメントするにはログインが必要です。'])
                ->withInput();
        }

        // コメント保存
    }
}
