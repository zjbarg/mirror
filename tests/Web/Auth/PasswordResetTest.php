<?php

namespace Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Mirror\Core\Accounts\Entities\User;
use Mirror\Core\Accounts\UsersRepository;
use Tests\Web\WebTestCase;

class PasswordResetTest extends WebTestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        /** @var User */
        $user = entity(User::class)->create();

        $this->post('/forgot-password', ['email' => $user->getEmailAddress()]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        /** @var User */
        $user = entity(User::class)->create();

        $this->post('/forgot-password', ['email' => $user->getEmailAddress()]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        /** @var User */
        $user = entity(User::class)->create();

        $this->post('/forgot-password', ['email' => $user->getEmailAddress()]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->getEmailAddress(),
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
