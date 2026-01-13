<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MakeProfileRequest;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function update(MakeProfileRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'postcode' => 'required|string',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        DB::transaction(function () use ($request, $user, $profile) {

            // users 更新
            $user->update([
                'name' => $request->name,
            ]);

            // 画像処理
            $path = $profile->profile_image;
            if ($request->hasFile('profile_image')) {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
                $path = $request->file('profile_image')
                    ->store('profiles', 'public');
            }

            // profiles 更新
            $profile->update([
                'name' => $request->name,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building,
                'profile_image' => $path,
            ]);
        });

        return redirect()->route('mypage');
    }

    // 編集画面の表示
    public function edit()
    {
        return view('profile', [
            'profile' => auth()->user()->profile,
        ]);
    }

    //
}
