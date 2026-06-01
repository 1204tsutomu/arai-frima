<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    public function showPage($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('items.purchase', compact('item'));
    }


    public function purchase(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);


        if (Order::where('item_id', $item->id)->exists()) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }


        Order::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
        ]);


        return redirect()->route('thanks');
    }
}
