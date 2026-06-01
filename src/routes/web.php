<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// ==========================================
// 1. 共通ルート（未ログインでも閲覧できる画面）
// ==========================================
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// ログアウトは未認証ユーザーでも実行できるようにここに配置します
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. メール認証関連ルート（ログイン必須・メール未認証でもOK）
// ==========================================
// 認証を促す誘導画面の表示
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// 認証メール内のリンクをクリックしたときの処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    // 認証完了後のリダイレクト先（仕様書の指示に合わせて適宜変更してください）
    return redirect()->route('profile.edit')->with('message', 'メール認証が完了しました！プロフィールを設定してください。');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メールの再送処理（「認証はこちらから」等のボタンに対応）
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', '認証メールを再送信しました！');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// ==========================================
// 3. ガードルート（ログイン ＆ メール認証が【完了】したユーザーのみ）
// ==========================================
// middlewareの配列に 'verified' を追加することで、未認証ユーザーを自動的に /email/verify へ弾きます
Route::middleware(['auth', 'verified'])->group(function () {

    // マイページ・プロフィール関連
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'editAddress'])->name('profile.editAddress');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'updateAddress'])->name('profile.updateAddress');

    // 出品関連
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    // 購入関連
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');
    Route::post('/purchase/{item_id}', [ItemController::class, 'buy'])->name('item.buy');

    // コメント・いいね
    Route::post('/item/{item_id}/comment', [ItemController::class, 'storeComment'])->name('comment.store');
    Route::post('/items/{item_id}/like', [LikeController::class, 'store'])->name('like.store');

    // サンクスページ
    Route::get('/thanks', function () {
        return view('items.thanks');
    })->name('thanks');
});
