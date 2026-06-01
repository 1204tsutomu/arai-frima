<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class T16_EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. 未認証のユーザーがガードされたページにアクセスした時、
     * メール認証誘導画面にリダイレクトされるかテスト
     */
    public function test_unverified_user_is_redirected_to_verification_notice()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertRedirect('/email/verify');
    }

    /**
     * 2. メール認証誘導画面（通知表示ページ）が正しく表示されるかテスト
     */
    public function test_verification_notice_screen_can_be_rendered()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
    }

    /**
     * 3. 認証メール内のリンクをクリックした時、
     * 正しく認証が完了し、プロフィール編集画面へ遷移するかテスト
     */
    public function test_email_can_be_verified()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('profile.edit'));
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    /**
     * 4. 「認証はこちらから」ボタンを押した際、
     * 認証メールが再送信されるかテスト
     */
    public function test_verification_email_can_be_resent()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertStatus(302);
        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
