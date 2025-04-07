<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class UserFilesTest extends TestCase
{
    public function test_user_can_get_files(): void
    {
        $user = User::factory()->create();

        File::factory(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('api/users/'.$user->id.'/files');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'files' => [
                    '*' => [
                        'id',
                        'file_name',
                        'file_path',
                        'comment',
                        'expiration_date',
                        'views_count',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_user_can_get_files_fails_invalid_id(): void
    {
        $response = $this->get('api/users/00/files');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'User not found.',
            ]);
    }
}
