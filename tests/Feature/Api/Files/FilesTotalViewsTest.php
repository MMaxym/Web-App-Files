<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class FilesTotalViewsTest extends TestCase
{
    public function test_user_can_get_total_views_files(): void
    {
        $user = User::factory()->create();

        File::factory(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('api/users/'.$user->id.'/files/total-views');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'total_views' => intval($response->json('total_views')),
            ]);
    }

    public function test_user_can_get_total_views_files_fails_invalid_id(): void
    {
        $response = $this->get('api/users/00/files/total-views');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'User not found.',
            ]);
    }
}
