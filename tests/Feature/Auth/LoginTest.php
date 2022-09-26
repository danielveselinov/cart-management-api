<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_email_and_password()
    {
        $user = User::factory()->create(['is_active' => 1]);

        $response = $this->postJson(route('auth.login'), [
            'login' => $user->email,
            'password' => 'password'
        ])->assertCreated();

        $this->assertArrayHasKey('access_token', $response->json());
    }

    public function test_user_can_login_with_phone_numer_and_password()
    {
        $user = User::factory()->create(['is_active' => 1]);

        $response = $this->postJson(route('auth.login'), [
            'login' => $user->phone_number,
            'password' => 'password'
        ])->assertCreated();

        $this->assertArrayHasKey('access_token', $response->json());
    }

    public function test_user_cant_login_without_an_active_account()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.login'), [
            'login' => $user->email,
            'password' => 'password'
        ])->assertForbidden();
    }

    public function test_if_user_dont_provide_email_or_phone_number_it_throws_an_error()
    {
        $this->postJson(route('auth.login'), [
            'login' => '',
            'password' => 'password'
        ])->assertUnprocessable();
    }

    public function test_if_user_try_to_login_without_password_it_throws_an_error()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.login'), [
            'login' => $user->email,
            'password' => ''
        ])->assertUnprocessable();
    }
}
