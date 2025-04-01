<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class SendEmailTest extends TestCase
{
    public function test_user_can_send_email(): void
    {
        User::where('email', 'johnTest2@example.com')->delete();

        User::factory()->create([
            'email' => 'johnTest2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $requestData = [
            'email' => 'johnTest2@example.com',
        ];

        $response = $this->postJson('/api/auth/password/email', $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Password reset link has been sent to your email address.',
            ]);
    }

    public function test_send_email_fails_invalid_email(): void
    {
        $requestData = [
            'email' => 'test@example.com',
        ];

        $response = $this->postJson('/api/auth/password/email', $requestData);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'User with this email does not exist.',
            ]);
    }

    public function test_send_email_fails_without_email(): void
    {
        $response = $this->postJson('/api/auth/password/email');

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The email field is required.',
                'errors' => [
                    'email' => [
                        'The email field is required.'
                    ],
                ],
            ]);
    }
}
