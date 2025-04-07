<?php

declare(strict_types=1);

namespace Tests\Feature\Api\FileLinks;

use App\Models\File;
use Illuminate\Foundation\Testing\TestCase;

class FileGenerateLinksTest extends TestCase
{
    public function test_user_can_generate_temporary_link_for_view_file(): void
    {
        $file = File::factory()->create();

        $request = [
            'type' => 'temporary',
        ];

        $response = $this->postJson('api/files/' . $file->id . '/generate-link', $request);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File link generated successfully.',
            ])
            ->assertJsonStructure([
                'link',
            ]);
    }

    public function test_user_can_generate_public_link_for_view_file(): void
    {
        $file = File::factory()->create();

        $request = [
            'type' => 'public',
        ];

        $response = $this->postJson('api/files/' . $file->id . '/generate-link', $request);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File link generated successfully.',
            ])
            ->assertJsonStructure([
                'link',
            ]);
    }

    public function test_user_can_generate_link_for_view_file_fails_with_invalid_type_link(): void
    {
        $file = File::factory()->create();

        $request = [
            'type' => 'test',
        ];

        $response = $this->postJson('api/files/' . $file->id . '/generate-link', $request);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonStructure([
                'errors',
            ]);
    }

    public function test_user_can_generate_link_for_view_file_fails_with_invalid_file_id(): void
    {
        $request = [
            'type' => 'public',
        ];

        $response = $this->postJson('api/files/00/generate-link', $request);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'File not found.',
            ]);
    }
}
