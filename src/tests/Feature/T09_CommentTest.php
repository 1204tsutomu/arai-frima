<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T09_CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 9. コメント送信機能のテスト
     */
    public function test_comment_submission_functionality()
    {
        // 1. テスト用の事前データ準備
        $condition = Condition::create(['condition' => '新品']);
        $seller = User::factory()->create();
        $user = User::factory()->create();

        $item = Item::create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'description' => 'これはテスト商品です。',
            'image_file' => 'items/test.jpg',
        ]);

        // ==========================================
        // 検証①: ログイン前のユーザーはコメントを送信できない
        // ==========================================
        $responseUnauthenticated = $this->post("/item/{$item->id}/comment", [
            'content' => 'ログイン前のコメントテスト'
        ]);

        // ログインページへリダイレクトされること
        $responseUnauthenticated->assertRedirect(route('login'));

        // ==========================================
        // 検証②: 値が未入力の場合にバリデーションエラー
        // ==========================================
        $responseEmpty = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => ''
        ]);
        $responseEmpty->assertSessionHasErrors(['content']);

        // ==========================================
        // 検証③: 255文字以上の場合にバリデーションエラー
        // ==========================================
        $longComment = str_repeat('あ', 256);
        $responseTooLong = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => $longComment
        ]);
        $responseTooLong->assertSessionHasErrors(['content']);

        // ==========================================
        // 検証④: 正しい入力値でコメントが保存され、件数が増加する
        // ==========================================
        $validComment = 'この商品はまだ購入可能ですか？';
        $responseValid = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => $validComment
        ]);

        // データベースにコメントが保存されていること
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => $validComment,
        ]);

        // 商品詳細ページを再取得して、送信したコメントとコメント数「1」が表示されていること
        $responseDetail = $this->actingAs($user)->get("/item/{$item->id}");
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee($validComment);
        $responseDetail->assertSee('1'); // 💬の横のカウントが1になっているか
    }
}
