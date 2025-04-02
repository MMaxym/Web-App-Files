<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\User;
use App\Models\File;
use Illuminate\Foundation\Testing\TestCase;

class FileDeleteTest extends TestCase
{
    public function test_user_can_delete_file(): void
    {
        User::where('email', 'johnTest8@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest8@example.com',
        ]);

        $file = File::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete('api/users/' . $user->id . '/files/' . $file->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'File moved to archive',
            ]);
    }

    public function test_user_can_delete_file_fails_with_invalid_user_id(): void
    {
        User::where('email', 'johnTest9@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest9@example.com',
        ]);

        $file = File::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete('api/users/00/files/' . $file->id);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'User not found.',
            ]);
    }

    public function test_user_can_delete_file_fails_with_invalid_file_id(): void
    {
        User::where('email', 'johnTest10@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest10@example.com',
        ]);

        $response = $this->delete('api/users/' . $user->id . '/files/00');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'File not found.',
            ]);
    }
}
