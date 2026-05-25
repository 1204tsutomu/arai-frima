<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T06_SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. 「商品名」で部分一致検索ができること
     */
    public function test_can_search_items_by_name_partial_match()
    {
        // 検索にヒットさせたい商品
        $matchItem1 = Item::factory()->create(['name' => '魔法のキーボード']);
        $matchItem2 = Item::factory()->create(['name' => '高級キーボード黒']);

        // 検索にヒットさせたくない商品
        $otherItem = Item::factory()->create(['name' => 'ワイヤレスマウス']);

        // キーワード「キーボード」で検索
        $response = $this->get('/?search=キーボード');

        $response->assertStatus(200);
        $response->assertSee('魔法のキーボード');
        $response->assertSee('高級キーボード黒');
        $response->assertDontSee('ワイヤレスマウス');
    }

    /**
     * 2. 検索状態がマイリストでも保持されていること
     */
    public function test_search_keyword_is_retained_on_mylist_tab()
    {
        $user = User::factory()->create();

        // 検索ワードに一致し、かつ「いいね」している商品（表示されるべき）
        $likedAndMatchedItem = Item::factory()->create(['name' => 'お気に入りのキーボード']);
        $user->likes()->attach($likedAndMatchedItem->id);

        // 検索ワードに一致するが、「いいね」していない商品（マイリストなので表示されないべき）
        $matchedButNotLikedItem = Item::factory()->create(['name' => '普通のキーボード']);

        // 検索ワードに一致しないが、「いいね」している商品（ワード違いなので表示されないべき）
        $likedButNotMatchedItem = Item::factory()->create(['name' => 'お気に入りのマウス']);
        $user->likes()->attach($likedButNotMatchedItem->id);

        // キーワード「キーボード」かつタブ「マイリスト」でアクセス
        $response = $this->actingAs($user)->get('/?search=キーボード&tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('お気に入りのキーボード');
        $response->assertDontSee('普通のキーボード');
        $response->assertDontSee('お気に入りのマウス');
    }
}
