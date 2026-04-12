<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ログイン画面を表示する
    public function index()
    {
        return view('auth.login'); // Viewのファイル名（login.blade.php）に合わせてくだされ
    }

    // ログイン処理（後のために枠だけ作っておきます）
    public function store(Request $request)
    {
        // ここにログイン認証の術を書きまする
    }

    // ログアウト処理
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
