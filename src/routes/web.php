<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MakeProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;

// 登録フォーム表示
Route::get('/register', [RegisterController::class, 'create'])->name('register');

// 登録処理。バリデーション → ユーザー作成 → ログイン → mailenable へリダイレクト
Route::post('/register', [RegisterController::class, 'store']);

// メール認証誘導画面へ遷移
Route::get('/mailenable', fn() => view('auth.mailenable'))->name('mailenable');


// ログインフォーム表示
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// ログイン画面
Route::post('/login', [LoginController::class, 'login'])->name('login');

// 認証メール誘導画面
Route::get('/mailenable', [MailController::class, 'showMailEnable'])
    ->middleware('auth')
    ->name('mailenable');

// 6桁コード入力画面
Route::get('/verification', [MailController::class, 'showVerification'])
    ->middleware('auth')
    ->name('verification');

// 6桁コード送信
Route::post('/verification', [MailController::class, 'verifyCode'])
    ->middleware('auth');

// 認証済みユーザーのみ
Route::middleware('auth')->group(
    function () {

        // プロフィール登録・入力フォーム表示
        Route::get('/makeprofile', [MakeProfileController::class, 'create'])->name('makeprofile.create');
        // プロフィール初回登録・フォーム送信
        Route::post('/makeprofile', [MakeProfileController::class, 'store'])->name('makeprofile.store');
        // プロフィール編集・編集画面表示
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        // プロフィール画面・フォーム送信   
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        // マイページ
        Route::get('/mypage', function () {
            return view('mypage');
        })->name('mypage');

        // 出品
        Route::get('/sell', function () {
            return view('sell');
        })->name('sell');

        // ログアウト
        Route::post('/logout', [MakeProfileController::class, 'logout'])
            ->name('logout');
    }
);

// 商品一覧ページ(ログイン後)
Route::get('/items', function () {
    return view('index');})->name('items.index');

    // 商品一覧ページ（ログイン後）
Route::get('/items', [ItemController::class, 'index'])
    ->name('items.index');
// 商品詳細画面
Route::get('/items/{id}', [ItemController::class, 'show'])
    ->name('items.show');

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
