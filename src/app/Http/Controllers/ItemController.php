<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\ContentRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); 
        $keyword = $request->query('keyword');

        if (!Auth::check()) {
            // 未ログイン → おすすめのみ表示
            $items = Item::with('categories')->latest();

            // ここで検索条件を追加
            if ($keyword) {
                $items->where('name', 'like', "%{$keyword}%");
            }
            $items = $items->paginate(7);
       
        }
        // ログイン済み
        if ($tab === 'wishlist') {

            $items = Auth::user()
                ->likedItems()
                ->with('categories')
                ->latest();
            if ($keyword) {
                $items->where('name', 'like', "%{$keyword}%");
            }

            $items = $items->paginate(7);    
                
        } else {

            $items = Item::with('categories')
                ->where('user_id', '!=', Auth::id())
                ->latest();
            if ($keyword) {
                $items->where('name', 'like', "%{$keyword}%");
            }

            $items = $items->paginate(7);    
        }

        return view('index', compact('items', 'tab'));
        
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
        $item->loadCount(['comments', 'likedUsers']);

        // ログインしている場合のみ、いいね済みか判定
        $isLiked = Auth::check()
            ? Auth::user()->likedItems()->where('item_id', $item->id)->exists()
            : false;
        // いいね数を取得
        $likesCount = $item->likedUsers()->count();
        $item->loadCount(['comments', 'likedUsers']);

        return view('content', compact('item', 'isLiked'));
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
    public function create(Request $request)
    {
        $uploadedImage = $request->session()->get('uploaded_image');

        return view('sell', compact('uploadedImage'));
    }
    // storage/app/public/items のファイル一覧
    // $files = Storage::files('public/items');

    // $images = [];
    // foreach ($files as $file) {
    //     $images[] = [
    //         'url' => asset(str_replace('public/', 'storage/', $file)), // 表示用URL
    //         'name' => basename($file), // ファイル名
    //     ];
    // }

    // return view('sell', compact('images'));
    // return view('sell');
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('items', 'public');

        // アップロード画像のパスをセッションに保存
        $request->session()->put('uploaded_image', $path);

        // 画像アップロード後に元の出品画面にリダイレクト
        return redirect()->route('sell');
    }
    // 出品する画像と商品名を保存
    public function storeItem(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'condition' => 'required|string',
            'image' => 'required|image|max:2048', // 画像必須・2MBまで
            'categories' => 'required|array',
        ]);

        $path = null;
        // 画像を保存してパスを取得
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            // 既存画像があればそのパスを使用
        } else if ($request->input('existing_image')) {
            $path = str_replace('/storage/', '', parse_url($request->input('existing_image'), PHP_URL_PATH));
            // $path = $request->input('existing_image');
        }

        // 価格を数値化
        $price = (int) str_replace(',', '', $request->price);

        // DBに保存。create()はfillableに入れたカラムのみ保存。createの戻り値を$itemに入れる。
        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'image' => $path,
            'price' => $price,
            'item_condition' => $request->condition,
            'brand' => $request->brand,
            'description' => $request->comment,
        ]);

        // 中間テーブルに保存
        $item->categories()->attach($request->categories);
        // 保存後mypageへリダイレクト
        return redirect('/mypage'); // 保存後トップにリダイレクト
    }

    public function mypage()
    {
        $userId = auth()->id();

        // 出品した商品
        $sellItems = Item::where('user_id', $userId)->get();

        // 購入した商品
        $purchasedItems = Purchase::where('buyer_id', $userId)->get();
            
        return view('mypage', compact('sellItems', 'purchasedItems'));
    }
    
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $items = Item::where('name', 'like', "%{$keyword}%")->get();

        return view('index', compact('items'));
    }
}
