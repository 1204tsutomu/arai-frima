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
Route::middleware('auth')->group(function () {
    // マイページ
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');

    // プロフィール編集
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 出品関連
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    // コメント投稿（グループの中に入れたので ->middleware('auth') は不要になります！）
    Route::post('/item/{item_id}/comment', [ItemController::class, 'storeComment'])->name('comment.store');
    Route::post('/items/{item_id}/like', [LikeController::class, 'store'])->name('like.store');
});
