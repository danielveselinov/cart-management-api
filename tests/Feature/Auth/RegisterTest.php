<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'John Doe',
            'email' => 'john@email.com',
            'phone_number' => '07550000',
            'password' => Hash::make('password'),
            'verification_code' => rand(1000, 9999),
        ])->assertCreated();

        $this->assertDatabaseHas('users', $response->json());
    }

    public function test_if_user_try_existing_email_for_registration_throws_an_error()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.register'), [
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'password' => Hash::make($user->password),
            'verification_code' => rand(1000, 9999),
        ])->assertUnprocessable();
    }

    public function test_if_user_try_existing_phone_number_for_registration_throws_an_error()
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.register'), [
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'password' => Hash::make($user->password),
            'verification_code' => rand(1000, 9999),
        ])->assertUnprocessable();
    }

    public function test_if_user_left_any_empty_fields_throws_an_errors()
    {
        $this->postJson(route('auth.register'))->assertUnprocessable();
    }
}
