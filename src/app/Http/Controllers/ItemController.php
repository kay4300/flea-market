<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\ContentRequest;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // デフォルト: おすすめ

        if (!Auth::check()) {
            // 未ログイン → おすすめのみ表示
            // $items = Item::latest()->paginate(7);
            $items = Item::with('categories')->latest()->paginate(7);
            return view('index', compact('items', 'tab'));
        }
        // ログイン済み
        if ($tab === 'wishlist') {

            $items = Auth::user()
                ->likedItems()
                ->with('categories')
                ->latest()
                ->paginate(7);
        } else {

            // $items = Item::latest()->paginate(7);
            $items = Item::with('categories')->latest()->paginate(7);
        }

        return view('index', compact('items', 'tab'));

        // ログインしている場合のみ、いいね済みIDを取得
        // $likedItemIds = Auth::check()
        //     ? Auth::user()->likedItems()->pluck('items.id')->toArray()
        //     : [];

        // return view('index', compact('items', 'tab', 'likedItemIds'));

        // ログイン済み
        // if ($tab === 'recommend') {
        //     $items = Item::latest()->paginate(7);
        // } elseif ($tab === 'wishlist') {
        //     $user = Auth::user();
        //     // いいねした商品のみ取得（pivotテーブルやlikesテーブル想定）
        //     $items = $user->likedItems()->latest()->paginate(7);
        // } else {
        //     $items = Item::latest()->paginate(7);
        // }

        // return view('index', compact('items', 'tab'));
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
    public function like(Item $item)
    {
        $user = Auth::user();

        if (!$user->likedItems()->where('item_id', $item->id)->exists()) {
            $user->likedItems()->attach($item->id);
        }

        return back();
    }

    public function unlike(Item $item)
    {
        $user = Auth::user();
        $user->likedItems()->detach($item->id);

        return back();
    }

    // 商品詳細画面
    // URLの {item} と自動で紐づく
    public function show(Item $item)
    {
        // eager loadingでcommentsとusersの情報をまとめて取得。$item->comments→ commentテーブルのデータ    
        $item->load(['user', 'categories', 'comments.user']);
        $item->loadCount('comments');

        // ログインしている場合のみ、いいね済みか判定
        $isLiked = Auth::check()
            ? Auth::user()->likedItems()->where('item_id', $item->id)->exists()
            : false;
        // いいね数を取得
        $likesCount = $item->likedUsers()->count();
        // $item->loadCount(['comments', 'likedUsers']);

        return view('content', compact('item', 'isLiked', 'likesCount'));
    }
    // 未ログイン画面からコメント送信したときのエラー処理
    public function store(ContentRequest $request, Item $item)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login')
        //         ->withErrors(['comment' => 'コメントするにはログインが必要です。'])
        //         ->withInput();
        // }
        $item->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('items.show', $item->id);
        // return back();
    }
    // 出品画面を表示
    public function create()
    {
        return view('sell');
    }
    // 出品する画像と商品名を保存
    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048', // 画像必須・2MBまで
        ]);

        $path = null;
        // 画像を保存してパスを取得
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }
        // DBに保存
        Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'image' => '/storage' . $path,
        ]);

        return redirect('/mypage'); // 保存後トップにリダイレクト
    }
}
