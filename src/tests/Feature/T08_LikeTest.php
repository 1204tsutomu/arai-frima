<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T08_LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 8. いいね機能のテスト（登録・解除・件数変化・要件シート画像の表示変化）
     */
    public function test_user_can_toggle_like_on_an_item()
    {
        // 1. テスト用の事前データ準備
        $user = User::factory()->create();
        $condition = Condition::create(['condition' => '新品']);
        $seller = User::factory()->create();

        $item = Item::create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'description' => 'これはテスト商品です。',
            'image_file' => 'items/test.jpg',
        ]);

        // まだいいねしていない状態で商品詳細ページを表示
        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertStatus(200);

        // 【検証】初期状態：いいね合計値は「0」であり、未いいね用の「heart.png」が表示されていること
        $response->assertSee('0');
        $response->assertSee('img/heart.png');

        // 2. いいね登録
        $likeResponse = $this->actingAs($user)->post("/items/{$item->id}/like");

        // 【検証】データベースにいいねが登録されていること
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // いいね登録後に再度詳細ページを表示
        $responseAfterLike = $this->actingAs($user)->get("/item/{$item->id}");

        // 【検証】いいね合計値が「1」に増加し、要件シートの「ハートロゴ_ピンク.png」に変わっていること
        $responseAfterLike->assertSee('1');
        $responseAfterLike->assertSee('ハートロゴ_ピンク.png');

        // 3. いいね解除（再度同じURLにPOSTしてトグルされるか検証）
        $unlikeResponse = $this->actingAs($user)->post("/items/{$item->id}/like");

        // 【検証】データベースからいいねが削除されていること
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // いいね解除後に再度詳細ページを表示
        $responseAfterUnlike = $this->actingAs($user)->get("/item/{$item->id}");

        // 【検証】いいね合計値が「0」に減少し、再び「heart.png」に戻っていること
        $responseAfterUnlike->assertSee('0');
        $responseAfterUnlike->assertSee('img/heart.png');
    }
}
