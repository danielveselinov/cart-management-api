<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_verify_account()
    {
        $user = User::factory()->create();

        $this->putJson(route('auth.verify-account', [
            'id' => $user->id,
            'verification_code' => $user->verification_code
        ]), ['is_active' => 1])->assertCreated();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'is_active' => 1]);
    }

    public function test_user_receive_verification_code()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.resend-code'), [
            'email' => $user->email
        ])->assertOk();
    }

    public function test_user_enter_invaid_email_throws_an_error()
    {
        $this->postJson(route('auth.resend-code'))->assertUnprocessable();
    }
}
