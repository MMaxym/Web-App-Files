<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class UpdateUserTest extends TestCase
{
    public function test_user_can_update(): void
    {
        User::where('email', 'johnTest4@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest4@example.com',
            'password' => bcrypt('password123'),
        ]);

        $requestDataLogin = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $responseLogin = $this->postJson('/api/auth/login', $requestDataLogin);

        $responseData = $responseLogin->json();
        $token = $responseData['token'];
        $this->assertIsString($token);

        $requestData = [
            'first_name' => $user->first_name . '_update',
            'last_name' => $user->last_name . '_update',
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        $response = $this->putJson('/api/users/' . $user->id, $requestData, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User information updated successfully',
            ]);
    }

    public function test_update_user_fails_without_token(): void
    {
        User::where('email', 'johnTest5@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest5@example.com',
            'password' => bcrypt('password123'),
        ]);

        $requestData = [
            'first_name' => $user->first_name . '_update',
            'last_name' => $user->last_name . '_update',
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        $response = $this->putJson('/api/users/' . $user->id, $requestData);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'error' => 'Unauthenticated',
            ]);
    }

    public function  test_update_user_fails_with_invalid_data(): void
    {
        User::where('email', 'johnTest6@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest6@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->putJson('/api/users/' . $user->id);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }
}
