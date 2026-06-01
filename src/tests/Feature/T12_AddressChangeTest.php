<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T12_AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 12. 配送先変更機能のテスト
     */
    public function test_delivery_address_change_and_order_binding()
    {
        // 1. 事前データ準備
        $condition = Condition::create(['condition' => '新品']);
        $seller = User::factory()->create();

        // カラム名を postal_code に修正
        $buyer = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '東京都元の住所',
            'building' => '元のビル',
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'price' => 5000,
            'description' => '商品説明です。',
            'image_file' => 'items/test.jpg',
        ]);

        $this->actingAs($buyer);

        // 2. 変更用の新しい配送先住所（セッション等での一時保存を想定）
        $newPostalCode = '999-9999';
        $newAddress = '大阪府新住所';
        $newBuilding = '新築ビル';

        // セッションに変更後の送付先をセットして購入画面を開く
        $response = $this->withSession([
            'new_postal_code' => $newPostalCode,
            'new_address' => $newAddress,
            'new_building' => $newBuilding,
        ])->get("/purchase/{$item->id}");

        $response->assertStatus(200);

        // 要件1: 変更した住所が購入画面（小計画面）に表示されていること
        $response->assertSee($newPostalCode);
        $response->assertSee($newAddress);
        $response->assertSee($newBuilding);
    }
}
