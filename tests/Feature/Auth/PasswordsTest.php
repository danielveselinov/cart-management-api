<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_receive_reset_password_code()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.resend-code'), [
            'email' => $user->email
        ])->assertOk();
    }

    public function test_user_dont_provide_valid_email()
    {
        $this->postJson(route('auth.resend-code'))->assertUnprocessable();
    }

    public function test_user_selected_token_is_invalid_throws_an_error()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.reset-password'), [
            'email' => $user->email,
            'token' => Str::random(64),
            'password' => 'Pass123#',
            'password_confirmation' => 'Pass123#'
        ])->assertUnprocessable();
    }
}
