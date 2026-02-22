<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MakeProfileIsCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // ログイン済みかつプロフィール未登録かつ現在のルートが makeprofile ではない場合
        if ($user && $user->profile === null && !$request->routeIs('makeprofile.create') && !$request->routeIs('makeprofile.store')) {
            return redirect()->route('makeprofile.create');
        }

        return $next($request);
    }
}
