<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T05_MylistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. いいねした商品だけが表示される
     */
    public function test_only_liked_items_are_displayed()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create(['name' => 'いいねした商品']);
        $otherItem = Item::factory()->create(['name' => 'その他の商品']);

        // ログインユーザーが商品に「いいね」を紐付ける
        $user->likes()->attach($likedItem->id);

        // マイリスト一覧（またはトップページのマイリストタブ）にアクセス
        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('その他の商品');
    }

    /**
     * 2. 購入済み商品は「Sold」と表示される
     */
    public function test_shows_sold_label_on_purchased_items_in_mylist()
    {
        $user = User::factory()->create();
        
        $soldItem = Item::factory()->create(['name' => '売却済みのマイリスト商品']);
        $user->likes()->attach($soldItem->id);
        
        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /**
     * 3. 未認証の場合は何も表示されない
     */
    public function test_nothing_is_displayed_when_unauthenticated()
    {
        $item = Item::factory()->create(['name' => 'ある商品']);

        $response = $this->get('/?tab=mylist');

        if ($response->status() === 200) {
            $response->assertDontSee('ある商品');
        } else {
            $response->assertRedirect('/login');
        }
    }
}
