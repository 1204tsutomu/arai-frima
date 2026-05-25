<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T07_ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 7. 商品詳細情報取得のテスト
     */
    public function test_can_view_item_detail_page_with_all_required_info()
    {
        // 必要なマスターデータの作成（状態）
        $condition = Condition::create(['condition' => '目立った傷や汚れなし']);

        // カテゴリの作成（content から name に修正！）
        $category1 = Category::create(['name' => 'ファッション']);
        $category2 = Category::create(['name' => 'メンズ']);

        // テスト用のユーザー（出品者とコメント投稿者）
        $seller = User::factory()->create();
        $commenter = User::factory()->create(['name' => 'コメント太郎']);

        // 商品の作成
        $item = Item::create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'name' => 'こだわりのレザージャケット',
            'brand' => 'ヴィンテージ革工房',
            'price' => 25000,
            'description' => 'これは最高品質のレザージャケットです。長く使えます。',
            'image_file' => 'items/test_jacket.jpg',
        ]);

        // カテゴリを紐付け
        $item->categories()->attach([$category1->id, $category2->id]);

        // コメントを紐付け
        Comment::create([
            'user_id' => $commenter->id,
            'item_id' => $item->id,
            'content' => 'この商品のサイズ感を教えてください。',
        ]);

        // 商品詳細ページ（/item/{item_id}）にアクセス
        $response = $this->get("/item/{$item->id}");

        // ステータスコード200を確認
        $response->assertStatus(200);

        // 仕様書にあるすべての情報が画面に表示されているか検品
        $response->assertSee('こだわりのレザージャケット'); // 商品名
        $response->assertSee('items/test_jacket.jpg');     // 商品画像
        $response->assertSee('ヴィンテージ革工房');         // ブランド名
        $response->assertSee('25,000') || $response->assertSee('25000'); // 価格
        $response->assertSee('これは最高品質のレザージャケットです。長く使えます。'); // 商品説明

        // カテゴリの表示確認
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');

        // 商品の状態の表示確認
        $response->assertSee('目立った傷や汚れなし');

        // コメント関連の表示確認
        $response->assertSee('コメント太郎'); // コメント残した人の名前
        $response->assertSee('この商品のサイズ感を教えてください。'); // コメント内容
    }
}
