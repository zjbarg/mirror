<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Mirror\Core\Accounts\Entities\User;
use Mirror\Core\Accounts\UsersRepository;
use Tests\Web\WebTestCase;

class PasswordConfirmationTest extends WebTestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = entity(User::class)->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $user = entity(User::class)->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = entity(User::class)->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
