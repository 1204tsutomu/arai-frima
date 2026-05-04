<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

// --- 商品関連 ---
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// --- 認証関連 ---
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ログイン必須の機能 ---
// --- ログイン必須の機能 ---
Route::middleware('auth')->group(function () {

    // 【Task 67-70】プロフィール表示画面 (マイページ本体)
    // URL: /mypage にアクセスすると、自分の情報と出品・購入リストが見える
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

    // 【Task 40-41】プロフィール編集画面
    // URL: /mypage/profile で住所などの設定・更新を行う
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'editAddress'])->name('profile.editAddress');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'updateAddress'])->name('profile.updateAddress');
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

    // --- 商品操作関連 ---
    // 出品画面の表示と保存
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');
    Route::post('/purchase/{item_id}', [ItemController::class, 'buy'])->name('item.buy');

    // 商品詳細画面でのアクション（コメント・いいね）
    Route::post('/item/{item_id}/comment', [ItemController::class, 'storeComment'])->name('comment.store');
    Route::post('/items/{item_id}/like', [LikeController::class, 'store'])->name('like.store');

    // ログアウト（POSTメソッド推奨）
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
