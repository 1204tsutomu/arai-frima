<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'  => 'required|string|max:255',
            'post_code' => 'required|string|max:8',
            'address'   => 'required|string|max:255',
            'building'  => 'nullable|string|max:255',
        ]);

       
        $user->update([
            'name' => $request->username,
        ]);

        // 【要確認】もし住所情報が別テーブル(profiles)ならここのコメントアウトを外します
        /*
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'post_code' => $request->post_code,
                'address'   => $request->address,
                'building'  => $request->building,
            ]
        );
        */

        return redirect()->back()->with('message', 'プロフィールを更新しました！');
    }
}
