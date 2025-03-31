<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class LogoutTest extends TestCase
{
    public function test_user_can_logout(): void
    {
        User::where('email', 'johnTest@example.com')->delete();

        User::factory()->create([
            'email' => 'johnTest@example.com',
            'password' => bcrypt('password123'),
        ]);

        $requestData = [
            'email' => 'johnTest@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/auth/login', $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful!',
            ]);

        $responseData = $response->json();
        $token = $responseData['token'];
        $this->assertIsString($token);

        $responseLogout = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseLogout->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful!',
            ]);

    }

    public function test_logout_fails_without_token(): void
    {
        $responseLogout = $this->postJson('/api/auth/logout');

        $responseLogout->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);
    }
}
