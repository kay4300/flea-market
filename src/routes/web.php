<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MakeProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EmailVerifiedRedirectController;

// 登録フォーム表示
// Route::get('/register', function () {
//     return view('register');
// })->middleware('guest')->name('register');

Route::get('/mailenable', function () {
    return view('mailenable');
})->middleware('auth')->name('mailenable');

// // 6桁コード入力画面
// Route::get('/verification', [RegisterController::class, 'showVerification'])
//     ->middleware('auth')
//     ->name('verification');

// // 6桁コード送信
// Route::post('/verification', [RegisterController::class, 'verifyCode'])
//     ->middleware('auth');

// 認証済みユーザーのみ
Route::middleware('auth', 'verified')->group(
    function () {

        // 「認証はこちらから」
        Route::get('/verified/redirect', [EmailVerifiedRedirectController::class, 'redirect'])
            ->name('verified.redirect');
        // プロフィール登録・入力フォーム表示
        Route::get('/makeprofile', [MakeProfileController::class, 'create'])->name('makeprofile.create');
        // プロフィール初回登録・フォーム送信
        Route::post('/makeprofile', [MakeProfileController::class, 'store'])->name('makeprofile.store');
        // プロフィール編集・編集画面表示
        Route::get('/profile/edit', [MakeProfileController::class, 'edit'])->name('profile.edit');
        // プロフィール画面・フォーム送信   
        Route::put('/profile', [MakeProfileController::class, 'update'])->name('profile.update');
        // マイページ
        Route::get('/mypage', function () {
            return view('mypage');
        })->name('mypage');

        // 出品
        Route::get('/sell', function () {
            return view('sell');
        })->name('sell');

        // 商品一覧ページ（ログイン後）
        Route::get('/items', [ItemController::class, 'index'])
            ->name('items.index');
        // 商品詳細画面
        Route::get('/items/{id}', [ItemController::class, 'show'])
            ->name('items.show');

        // ログアウト
        Route::post('/logout', [MakeProfileController::class, 'logout'])
            ->name('logout');
    }
);

// 商品一覧ページ(ログイン前)
Route::get('/items', function () {
    return view('index');
})->name('items.index');



// 未ログイン画面からコメント送信したときのエラー処理
Route::post('/content2', [ItemController::class, 'store'])
    ->middleware('auth');

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/', [ItemController::class, 'index'])->name('top');

// Route::middleware(['web', 'guest'])->group(function () {
//     Route::get('/register', [RegisterController::class, 'create'])->name('register');
//     Route::post('/register', [RegisterController::class, 'store']);
// });


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
