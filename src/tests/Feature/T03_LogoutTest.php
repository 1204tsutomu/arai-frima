<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class T03_LogoutTest extends TestCase
{
    use RefreshDatabase; // 実行のたびにDBをリセット

    /**
     * ログアウトができる
     */
    public function test_logout_success()
    {
        // 1. ユーザーを作成してログイン状態にする
        $user = User::factory()->create();
        $this->actingAs($user); // 指定したユーザーでログインしたことにする

        // 2. ログアウトボタン（エンドポイント）を叩く
        $response = $this->post('/logout');

        // 3. ログアウト処理が実行されていることを確認
        $this->assertGuest(); // 認証されていない（ゲスト状態）であることを検証

        // 4. ログアウト後の遷移先（一般的にはトップページなど）を確認
        $response->assertRedirect('/');
    }
}
