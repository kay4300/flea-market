<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Item;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($itemId)
    {
        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $itemId,
        ]);

        return redirect()->route('mypage'); 
    }

    public function editProfile()
    {
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();
        return view('profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::id();

        $profile = Profile::where('user_id', $userId)->firstOrFail();

        // バリデーション
        $validated = $request->validate([
            'postcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
        ]);

        $profile->update($validated);

        // 更新後、購入ページに戻す
        return redirect()->route('purchase.show', session('purchase_item_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
        $item = Item::findOrFail($itemId);
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();

        // ← ここで session に保存
        session(['purchase_item_id' => $itemId]);

        return view('purchase', compact('item', 'profile'));
        //
    }

    public function purchase($id)
    {
        $item = Item::findOrFail($id);

        if ($item->is_sold) {
            return back();
        }

        $item->is_sold = true;
        $item->buyer_id = auth()->id();
        $item->save();

        return redirect()->route('purchase.show', $item->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
