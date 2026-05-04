<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * プロフィール表示画面 (Task 67-70)
     */
    public function index()
    {
        $user = Auth::user();

        // 自分が「出品した商品」を取得
        $sellingItems = Item::where('user_id', $user->id)->get();

        // 購入履歴（まだ未実装なら一旦空のままでOK）
        $purchasedItems = [];

        return view('profile.index', compact('user', 'sellingItems', 'purchasedItems'));
    }

    /**
     * プロフィール編集画面 (Task 71-72)
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * プロフィール更新処理 (Task 73)
     */
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

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $updateData['img_url'] = $path;
        }

        $user->update($updateData);

        return redirect()->route('profile.index')->with('message', 'プロフィールを更新しました！');
    }

    /**
     * 住所変更画面（購入手続きから）
     */
    public function editAddress($item_id)
    {
        $user = Auth::user();
        return view('profile.edit_address', compact('user', 'item_id'));
    }

    /**
     * 住所更新処理（購入手続きへ戻る）
     */
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

        // 更新後は購入画面に戻る
        return redirect()->route('item.purchase', ['item_id' => $item_id]);
    }
}
