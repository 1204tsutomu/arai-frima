<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();


        $sellingItems = Item::where('user_id', $user->id)->get();


        $purchasedItemIds = Order::where('user_id', $user->id)->pluck('item_id');
        $purchasedItems = Item::whereIn('id', $purchasedItemIds)->get();

        return view('profile.index', compact('user', 'sellingItems', 'purchasedItems'));
    }


    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'    => 'required|string|max:255',
            'postal_code' => 'required|string|max:8',
            'address'     => 'required|string|max:255',
            'building'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $updateData = [
            'name'        => $request->username,
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ];


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $updateData['image_file'] = $path;
        }

        $user->update($updateData);

        return redirect()->route('profile.index')->with('message', 'プロフィールを更新しました！');
    }


    public function editAddress($item_id)
    {
        $user = Auth::user();
        return view('profile.edit_address', compact('user', 'item_id'));
    }


    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => 'required|string|max:8',
            'address'     => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);


        return redirect()->route('item.purchase', ['item_id' => $item_id]);
    }
}
