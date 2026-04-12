<?php

namespace App\Http\Controllers;

use App\Models\Item; // Itemモデルをインポート
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * 商品一覧画面を表示する
     */
    public function index()
    {
        // 1. itemsテーブルから全データを取得
        $items = Item::all();

        // 2. viewにデータを渡して表示（'items.index' は resources/views/items/index.blade.php を指します）
        return view('items.index', compact('items'));
    }
}
