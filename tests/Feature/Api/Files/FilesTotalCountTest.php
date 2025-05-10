<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class FilesTotalCountTest extends TestCase
{
    public function test_user_can_get_total_count_files(): void
    {
        $user = User::factory()->create();

        File::factory(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('api/users/'.$user->id.'/files/total-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'files_count' => intval($response->json('files_count')),
            ]);
    }

    public function test_user_can_get_total_count_files_fails_invalid_id(): void
    {
        $response = $this->get('api/users/00/files/total-count');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'User not found.',
            ]);
    }
}
