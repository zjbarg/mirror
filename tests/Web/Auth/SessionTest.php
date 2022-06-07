<?php

namespace Tests\Web\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mirror\Core\Accounts\Entities\User;
use Mirror\Web\Providers\RouteServiceProvider;
use Tests\Web\WebTestCase;

class SessionTest extends WebTestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        /** @var User */
        $user = entity(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->getEmailAddress(),
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        /** @var User */
        $user = entity(User::class)->create();

        $this->post('/login', [
            'email' => $user->getEmailAddress(),
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
