<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\File;
use Illuminate\Foundation\Testing\TestCase;

class DetailsFileTest extends TestCase
{
    public function test_user_can_view_file_details(): void
    {
        $file = File::factory()->create();

        $response = $this->get('/api/files/' . $file->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'file' => [
                    'id',
                    'user_id',
                    'file_name',
                    'file_path',
                    'comment',
                    'expiration_date',
                    'views_count',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ],
            ]);
    }

    public function test_user_can_view_file_details_fails_invalid_id(): void
    {
        $response = $this->get('/api/files/00');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'File not found.',
            ]);
    }
}
