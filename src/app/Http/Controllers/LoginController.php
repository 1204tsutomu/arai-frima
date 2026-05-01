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
        // 1. バリデーション（入力チェック）
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. ログインを試みる
        if (Auth::attempt($credentials)) {
            // セッションの再生成（セキュリティ対策）
            $request->session()->regenerate();

            // 成功したらトップページへ
            return redirect()->intended('/');
        }

        // 3. 失敗したらエラーメッセージを持って戻る
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
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
