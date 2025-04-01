<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_login(): void
    {
        User::where('email', 'johnDoe@example.com')->delete();

        User::factory()->create([
            'email' => 'johnDoe@example.com',
            'password' => bcrypt('password123'),
        ]);

        $requestData = [
            'email' => 'johnDoe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/auth/login', $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful!',
            ]);

        $responseData = $response->json();
        $this->assertIsString($responseData['token']);
    }

    public function test_login_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/auth/login');

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    public function test_login_fails_with_invalid_password(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'johnDoe@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                "success" => false,
                'errors' => [
                    "password" => 'Incorrect password',
                ],
            ]);
    }

    public function test_login_fails_with_invalid_email(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'johnDoe1@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                "success" => false,
                'errors' => [
                    "email" => 'Email not found',
                ],
            ]);
    }
}
