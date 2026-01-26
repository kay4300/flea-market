<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function create()
    {
        return view('makeprofile');
    }

    public function store(Request $request)
    {
        DB::table('create_profile_table')->insert([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('items.index');
    }
}
