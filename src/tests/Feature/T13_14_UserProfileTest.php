<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T13_14_UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 13. ユーザー情報取得テスト
     */
    public function test_user_profile_page_displays_correct_info()
    {
        $condition = Condition::create(['condition' => '新品']);
        
        // 1. テストユーザー（自分）の作成
        $user = User::factory()->create([
            'name' => 'タイガユーザー',
            'image_file' => 'profiles/test_avatar.jpg',
        ]);
        
        // 2. 他のユーザーを作成（出品者・購入者のシミュレート用）
        $otherUser = User::factory()->create();

        // 3. 自分が「出品した」商品
        $myProduct = Item::create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => '私が出品した格好良い商品',
            'price' => 1000,
            'description' => '説明文',
            'image_file' => 'items/my.jpg',
        ]);

        // 4. 他人が出品した商品
        $otherProduct = Item::create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'name' => '私が購入した素敵な商品',
            'price' => 2000,
            'description' => '説明文2',
            'image_file' => 'items/other.jpg',
        ]);

        // 5. 自分が「購入した」履歴（注文データ）を作成
        Order::create([
            'user_id' => $user->id,
            'item_id' => $otherProduct->id,
            'payment_method' => 'カード支払い',
        ]);

        // ログインしてマイページを開く
        $this->actingAs($user);
        
        // --- ① デフォルト（または出品中タブ）の検証 ---
        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('タイガユーザー');
        $response->assertSee('私が出品した格好良い商品');

        // --- ② 購入した商品タブの検証 ---
        // 実装に合わせて ?page=purchased を指定してリクエストを送る
        $response = $this->get('/mypage?page=purchased');
        $response->assertStatus(200);
        $response->assertSee('私が購入した素敵な商品');
    }

    /**
     * 14. ユーザー情報変更（初期値表示）テスト
     */
    public function test_user_profile_edit_page_shows_existing_values_as_defaults()
    {
        $user = User::factory()->create([
            'name' => '初期名前',
            'postal_code' => '123-4567',
            'address' => '初期の住所データ',
            'building' => '初期ビルディング',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        // 各項目が初期値として画面に含まれているか
        $response->assertSee('初期名前');
        $response->assertSee('123-4567');
        $response->assertSee('初期の住所データ');
    }
}
