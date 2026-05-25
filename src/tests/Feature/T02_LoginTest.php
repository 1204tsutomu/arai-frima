<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class T02_LoginTest extends TestCase
{
    use RefreshDatabase; // データベースをリセットするリーダーの嗜み

    /**
     * 1. メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /**
     * 2. パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /**
     * 3. 入力情報が間違っている場合、バリデーションメッセージが表示される
     */
    public function test_invalid_login_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // 確認が終わったので dumpSession は消してもOKです！
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。'
        ]);
    }

    /**
     * 4. 正しい情報が入力された場合、ログイン処理が実行される
     */
    public function test_login_success()
    {
        // テスト用のユーザーを作成
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // ログイン状態であることを確認
        $this->assertAuthenticatedAs($user);

        // ログイン後の遷移先（一般的にはトップページなど）を確認
        $response->assertRedirect('/');
    }
}
