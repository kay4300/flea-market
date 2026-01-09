<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    /**
     * 認証メール誘導画面表示
     */
    public function showMailEnable()
    {
        return view('mailenable');
    }

    /**
     * 6桁コード入力画面表示
     */
    public function showVerification()
    {
        return view('verification');
    }

    /**
     * 6桁コード検証
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        // 仮コード '123456' と照合
        if ($request->verification_code === '123456') {
            return redirect()->route('makeprofile');
        }

        return back()->withErrors(['verification_code' => '認証コードが間違っています']);
    }
}
