<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T11_PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 11. 支払い方法選択機能のテスト
     */
    public function test_payment_method_selection_and_reflection()
    {
        $condition = Condition::create(['condition' => '新品']);
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $item = Item::create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'price' => 3000,
            'description' => '商品説明です。',
            'image_file' => 'items/test.jpg',
        ]);

        $this->actingAs($buyer);
        
        $selectedMethod = 'コンビニ払い';
        
        $response = $this->withSession(['payment_method' => $selectedMethod])
                         ->get("/purchase/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee($selectedMethod);
    }
}
