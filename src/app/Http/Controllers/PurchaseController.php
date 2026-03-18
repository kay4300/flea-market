<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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

    public function editProfile($itemId)
    {
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();
        $item = Item::findOrFail($itemId);
        return view('address', compact('profile', 'item'));
    }

    public function updateProfile(Request $request, $itemId)
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
        return redirect()->route('purchase.show', $itemId);
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

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price, // 円（例: 1000）
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('index.afterlogin'),
            'cancel_url' => route('index.afterlogin'),
            'metadata' => ['item_id' => $item->id],
        ]);

        // ② Stripe 画面に遷移した時点で購入データを登録
        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'stripe_session_id' => $session->id,
            'amount' => $item->price,
        ]);

        // ③ 商品に sold フラグを立てる
        $item->is_sold = true;
        $item->save();

        return redirect($session->url);
    }

    //     if ($item->is_sold) {
    //         return back();
    //     }

    //     $item->is_sold = true;
    //     $item->buyer_id = auth()->id();
    //     $item->save();

    //     return redirect()->route('purchase.show', $item->id);
    // }


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
