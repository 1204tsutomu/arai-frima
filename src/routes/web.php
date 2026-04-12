<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/mypage/profile', [UserController::class, 'update'])->name('profile.update');
