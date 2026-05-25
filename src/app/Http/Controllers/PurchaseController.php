<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    // 商品購入画面を表示
    public function showPage($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('items.purchase', compact('item'));
    }

    // 購入を確定する処理
    public function purchase(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // すでに売り切れている場合はエラー、またはリダイレクト
        if (Order::where('item_id', $item->id)->exists()) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        // 注文の作成（購入完了）
        Order::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
        ]);

        // サンクスページ（thanks.blade.php）などへリダイレクト
        return redirect()->route('thanks');
    }
}
