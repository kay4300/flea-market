<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->take(3)->get(); // 3件表示

        return view('index', compact('items'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        return view('content', compact('item'));
    }
    //
}
