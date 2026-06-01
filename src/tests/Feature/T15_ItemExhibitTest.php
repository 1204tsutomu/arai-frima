<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Condition;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class T15_ItemExhibitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 15. 出品商品情報登録（商品出品機能）テスト
     */
    public function test_user_can_successfully_exhibit_item()
    {
        Storage::fake('public');

        // 1. 前提データの用意
        $user = User::factory()->create();
        $condition = Condition::create(['condition' => '新品、未使用']);
        $category = Category::create(['name' => 'ファッション']);

        $this->actingAs($user);

        // 2. 本物の画像として判定される最小限のGIFバイナリデータを用意してアップロード
        // (GDがなくても image バリデーションを通過させるための対策)
        $gifImage = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
        $image = UploadedFile::fake()->createWithContent('jacket.jpg', $gifImage);

        // 3. コントローラーの実装に合わせてリクエストデータを構築
        $exhibitData = [
            'name' => 'タイガ特製最高級ジャケット',
            'price' => 15000,
            'description' => 'これは素晴らしい最高級のジャケットです。',
            'condition_id' => $condition->id,
            'categories' => [$category->id], // 配列形式に修正
            'image' => $image,
        ];

        // 4. 出品処理を実行
        $response = $this->post('/sell', $exhibitData);

        // 5. ステータスコードの検証（一覧画面へのリダイレクトを想定した302）
        $response->assertStatus(302);

        // 6. データベースに商品が正しく登録されているか検証
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'タイガ特製最高級ジャケット',
            'price' => 15000,
            'description' => 'これは素晴らしい最高級のジャケットです。',
            'condition_id' => $condition->id,
        ]);
    }
}
