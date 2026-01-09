<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;

// 登録フォーム表示
Route::get('/register', [RegisterController::class, 'create'])->name('register');

// 登録処理。バリデーション → ユーザー作成 → ログイン → mailenable へリダイレクト
Route::post('/register', [RegisterController::class, 'store']);

// メール認証誘導画面へ遷移
Route::get('/mailenable', fn() => view('auth.mailenable'))->name('mailenable');

// ログイン画面
Route::get('/login', [LoginController::class, 'create'])
    ->name('login');

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
