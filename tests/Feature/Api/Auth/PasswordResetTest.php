<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_reset_password_fails_invalid_token(): void
    {
        User::where('email', 'johnTest3@example.com')->delete();

        User::factory()->create([
            'email' => 'johnTest3@example.com',
            'password' => bcrypt('password123'),
        ]);

        $requestData = [
            'email' => 'johnTest3@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'token' => 'test_7e84c51e6b18911eabf557eabf1057ae',
        ];

        $response = $this->postJson('/api/auth/password/reset', $requestData);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'This password reset token is invalid.',
            ]);
    }

    public function test_reset_password_fails_invalid_email(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'token' => 'test_7e84c51e6b18911eabf557eabf1057ae',
        ];

        $response = $this->postJson('/api/auth/password/reset', $requestData);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'We can\'t find a user with that email address.',
            ]);
    }

    public function  test_reset_password_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/auth/password/reset');

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
}
