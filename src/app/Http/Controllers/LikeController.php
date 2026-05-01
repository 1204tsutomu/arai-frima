<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($item_id)
    {
        $user_id = Auth::id();

        // すでに「いいね」しているかチェック
        $already_liked = Like::where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->first();

        if (!$already_liked) {
            // まだなら、いいねを登録
            Like::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
            ]);
        } else {
            // すでにしているなら、いいねを解除（削除）
            $already_liked->delete();
        }

        return back();
    }
}
