<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class FilesDeletedCountTest extends TestCase
{
    public function test_user_can_get_deleted_count_files(): void
    {
        $user = User::factory()->create();

        File::factory(5)->create([
            'user_id' => $user->id,
            'deleted_at' => now(),
        ]);

        $response = $this->get('api/users/'.$user->id.'/files/deleted-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'deleted_files_count' => intval($response->json('deleted_files_count')),
            ]);
    }

    public function test_user_can_get_deleted_count_files_fails_invalid_id(): void
    {
        $response = $this->get('api/users/00/files/deleted-count');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'User not found.',
            ]);
    }
}
