<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Content2Request;
use App\Models\Item;

class ItemController extends Controller
{
    // ログイン前、トップ画面
    public function index()
    {
        $items = Item::latest()->take(3)->get(); // 3件表示

        return view('fleamarket', compact('items'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

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


