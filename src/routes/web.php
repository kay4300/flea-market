<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MakeProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EmailVerifiedRedirectController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LoginController;
use App\Models\Item;

// 登録フォーム表示
// Route::get('/register', function () {
//     return view('register');
// })->middleware('guest')->name('register');

// メール認証ルート
// Auth::routes(['verify' => true]);

// メール認証誘導画面
Route::get('/mailenable', function () {
    return view('mailenable');
})->middleware('auth')->name('mailenable');

// メール認証画面（新規）
Route::get('/mailverification', function () {
    return view('mailverification');
})->name('mailverification');

// メール認証（ユーザーがメール内のリンクをクリックしたときの処理）
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $request->fulfill();    

    $user = Auth::user();
    $profile = $user->profile;

    // プロフィールが存在しない OR 必須項目が空なら作成画面へ
    if (!$profile || empty($profile->postcode) || empty($profile->address) || empty($profile->building)) {
        return redirect()->route('makeprofile.create');
    }

    // プロフィール登録画面へ
    // if (! $request->user()->profile) {
    //     return redirect()->route('makeprofile.create');
    // }
    // 登録済みならindexへ
    return redirect()->route('index.afterlogin');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/after-verify', [EmailVerifiedRedirectController::class, 'redirect'])
    ->middleware(['auth', 'signed'])
    ->name('after.verify');

// 認証済みユーザーのみ
Route::middleware('auth')->group(
    function () {

        Route::post('/verified/redirect', function (Request $request) {

            $user = $request->user();

            // ユーザーをメール認証済みにする
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            // Eager Load で profile を確認
            // $user->load('profile');

            // プロフィール未登録なら makeprofile へ
            if (!$user->profile) {
                return redirect()->route('makeprofile.create');
            }
            // return redirect()->route('index.afterlogin');

            // 登録済みなら index へ
            return redirect()->route('index.afterlogin');
        })->name('verified.redirect');

        // 商品一覧（after login）
        Route::get('/index', [ItemController::class, 'index'])
            ->name('index.afterlogin')
            ->middleware('profile.completed');
        
            
        //いいね追加 
        Route::post('/items/{item}/like', [ItemController::class, 'like'])
            ->name('items.like');
        // いいね削除
        Route::delete('/items/{item}/unlike', [ItemController::class, 'unlike'])
            ->name('items.unlike');
        // コメント追加
        Route::get('/item/{id}', [ItemController::class, 'show']);
        // コメント保存
        Route::post('/item/{item}/comment', [ItemController::class, 'store'])->name('items.comment');


        // プロフィール登録・入力フォーム表示
        Route::get('/makeprofile', [MakeProfileController::class, 'create'])->name('makeprofile.create');
        // プロフィール初回登録・フォーム送信
        Route::post('/makeprofile', [MakeProfileController::class, 'store'])->name('makeprofile.store');
        // index 画面
        // Route::get('/index', function () {
        //     return view('index');
        // })->name('index.afterlogin');

        // プロフィール編集・編集画面表示
        Route::get('/profile/edit', [MakeProfileController::class, 'edit'])->name('profile.edit');
        // プロフィール画面・フォーム送信   
        Route::put('/profile', [MakeProfileController::class, 'update'])->name('profile.update');

        // マイページ
        Route::get('/mypage', [MypageController::class, 'index'])
            ->name('mypage');

        // 出品
        Route::get('/sell', function () {
            return view('sell');
        })->name('sell');

        // 購入画面を表示
        Route::get('/purchase/{item}', [MypageController::class, 'show'])
            ->name('purchase.show');

        // 購入画面。{item} は商品IDを受け取るためのパラメータ
        Route::post('/purchase/{item}', [MypageController::class, 'purchase'])
            ->name('purchase');

        // 住所変更画面
        Route::get('/address/edit', [MypageController::class, 'editAddress'])
            ->name('address.edit');

        // ログアウト
        Route::post('/logout', [MakeProfileController::class, 'logout'])->name('logout');
    }
);

// 商品詳細画面
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');


// トップページ（ログイン前・ログイン後共通）
Route::get('/', [ItemController::class, 'index'])->name('top');
// ログイン画面へ遷移
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route::get('/index', function (Request $request) {
//     $tab = $request->query('tab', 'recommend');
//     $items = Item::latest()->take(3)->get();
//     return view('index', compact('items', 'tab'));
// })->name('index.afterlogin');


// 未ログイン画面からコメント送信したときのエラー処理
Route::post('/content2', [ItemController::class, 'store'])
    ->middleware('auth');


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
