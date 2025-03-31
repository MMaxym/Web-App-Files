<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class RegisterTest extends TestCase
{
    public function test_user_can_register(): void
    {
        User::where('email', 'john@doe.com')->delete();

        $requestData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '380991234567',
        ];

        $response = $this->postJson('/api/auth/register', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful!',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $requestData['email'],
        ]);
    }

    public function test_registration_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/auth/register', []);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function test_registration_fails_when_email_is_taken(): void
    {
        $requestData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '380991234567',
        ];

        $response = $this->postJson('/api/auth/register', $requestData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The email has already been taken.',
                'errors' => [
                    'email' => [
                        'The email has already been taken.'
                    ]
                ]
            ]);
    }
}
