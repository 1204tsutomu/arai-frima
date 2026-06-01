<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;


class ItemController extends Controller
{
    /**
     * 商品一覧表示
     */
    public function index(Request $request)
    {
        // クエリパラメータからタブと検索キーワードを取得
        $tab = $request->query('tab', 'recommend');
        $search = $request->query('search');

        if ($tab === 'mylist') {
            // ==========================================
            // 【マイリストタブ】が選択された場合
            // ==========================================
            if (Auth::check()) {
                // 自分が「いいね」した商品をベースにするクエリを作成
                $query = Auth::user()->likes();

                // 検索キーワードがあれば、商品名で部分一致検索を追加
                if (!empty($search)) {
                    $query->where('name', 'like', '%' . $search . '%');
                }

                $items = $query->get();
            } else {
                $items = collect();
            }
        } else {
            // ==========================================
            // 【おすすめタブ（デフォルト）】の場合
            // ==========================================
            // 基本的な商品のクエリを作成
            $query = Item::query();

            if (Auth::check()) {
                // ログインしている場合は自分以外の出品商品
                $query->where('user_id', '!=', Auth::id());
            }

            // 検索キーワードがあれば、商品名で部分一致検索を追加
            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $items = $query->get();
        }

        // ビューに $items, $tab, そして入力された $search ワードを渡す
        return view('items.index', compact('items', 'tab', 'search'));
    }
    public function show($item_id)
    {
        // categories, likes, comments（とその投稿者）をまとめて取得してエラーを防ぐ
        $item = Item::with(['categories', 'likes', 'comments.user'])->findOrFail($item_id);

        return view('items.item_detail', compact('item'));
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

    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        // セッションに変更後の住所があれば取得、なければユーザーの初期住所を使う
        $postal_code = session('new_postal_code', $user->postal_code);
        $address = session('new_address', $user->address);
        $building = session('new_building', $user->building);

        return view('items.purchase', compact('item', 'user', 'postal_code', 'address', 'building'));
    }
    public function buy(Request $request, $item_id)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);

        $user = Auth::user();

        // セッションに変更後の住所があればそれを使い、なければユーザーの初期住所を使う
        $postal_code = session('new_postal_code', $user->postal_code);
        $address = session('new_address', $user->address);
        $building = session('new_building', $user->building);

        // データベースに購入情報と配送先住所を紐づけて保存
        Order::create([
            'user_id'        => $user->id,
            'item_id'        => $item_id,
            'payment_method' => $request->payment_method,
            'postal_code'    => $postal_code,
            'address'        => $address,
            'building'       => $building,
        ]);

        // 購入が完了したので、配送先変更の一時セッションをクリアする
        session()->forget(['new_postal_code', 'new_address', 'new_building']);

        return redirect()->route('items.index')->with('message', '購入が完了しました！');
    }
    public function create()
    {
        $categories = \App\Models\Category::all();
        $conditions = \App\Models\Condition::all(); // 商品の状態（新品、中古など）

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string|max:1000',
            'price'        => 'required|integer|min:0',
            'condition_id' => 'required|exists:conditions,id',
            'categories'   => 'required|array', // カテゴリーは複数選択（配列）
            'image'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => '商品名を入力してください',
            'image.required' => '商品画像を選択してください',
            'categories.required' => 'カテゴリーを選択してください',
            'price.required' => '価格を入力してください',
        ]);

        // 1. 画像の保存
        $path = $request->file('image')->store('items', 'public');

        // 2. 商品データの作成
        $item = Item::create([
            'user_id'      => auth()->id(),
            'condition_id' => $request->condition_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'image_file'    => $path, // 画像のパスを保存
        ]);

        // 3. カテゴリーの紐付け（中間テーブルへの保存）
        // Itemモデルに categories() リレーションがある前提です
        $item->categories()->attach($request->categories);

        return redirect()->route('items.index')->with('message', '商品を出品しました！');
    }
}
