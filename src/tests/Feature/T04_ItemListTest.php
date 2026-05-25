<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T04_ItemListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. すべての商品が取得できる
     */
    public function test_can_get_all_items()
    {
        // 商品を3つ作成
        Item::factory()->count(3)->create();

        // トップページにアクセス
        $response = $this->get('/');

        $response->assertStatus(200);
        // 作成した商品が画面に存在する（空でない）ことを検証
        $this->assertCount(3, $response->viewData('items'));
    }

    /**
     * 2. 購入済み商品は「Sold」と表示される
     */
    public function test_shows_sold_label_on_purchased_items()
    {
        // 出品者と購入者、商品を作成
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $seller->id, 'name' => '売却済み商品']);

        // 注文データを作成（必須カラム payment_method を指定）
        Order::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'card'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // 画面に「Sold」の文字が含まれているか検証
        $response->assertSee('Sold');
    }

    /**
     * 3. 自分が出品した商品は表示されない
     */
    public function test_does_not_show_own_items()
    {
        // ログインするユーザー（自分）を作成
        $me = User::factory()->create();

        // 自分の商品と、他人の商品を作成
        Item::factory()->create(['user_id' => $me->id, 'name' => '俺の商品']);
        Item::factory()->create(['name' => '他人の商品']);

        // 自分としてログインしてトップページへ
        $response = $this->actingAs($me)->get('/');

        $response->assertStatus(200);
        $response->assertSee('他人の商品');
        $response->assertDontSee('俺の商品'); // 自分のは見えないはず！
    }
}
