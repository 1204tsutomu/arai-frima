<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment; // これが必要！
use App\Models\Like;    // これも必要！

class ItemController extends Controller
{
    /**
     * 商品一覧表示
     */
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * 商品詳細表示
     */
    public function show($item_id)
    {
        // categories, likes, comments（とその投稿者）をまとめて取得してエラーを防ぐ
        $item = Item::with(['categories', 'likes', 'comments.user'])->findOrFail($item_id);

        return view('item_detail', compact('item'));
    }

    /**
     * コメント投稿機能
     */
    public function storeComment(Request $request, $item_id)
    {
        // 第2引数にカスタムメッセージを追加します
        $request->validate([
            'content' => 'required|max:255',
        ], [
            'content.required' => 'コメントを入力してください',
            'content.max'      => 'コメントは255文字以内で入力してください',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'content' => $request->content,
        ]);

        return back()->with('message', 'コメントを投稿しました');
    }
}
