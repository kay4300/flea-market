<?php

    namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('mailenable');
        }

        if ($user->profile) {
            return redirect()->route('index.afterlogin');
        }

        return redirect()->route('makeprofile.create');
    }
}