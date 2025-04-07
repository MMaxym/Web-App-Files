<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Files;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestCase;

class FileUploadTest extends TestCase
{
    public function test_user_can_upload_file(): void
    {
        User::where('email', 'johnTest7@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest7@example.com',
        ]);

        $file = UploadedFile::fake()->create('test_document.pdf', 1000, 'application/pdf');

        $requestData = [
            'user_id' => $user->id,
            'file' => $file,
            'comment' => 'Test file comment',
            'expiration_date' => now()->addDays(5)->toDateString(),
        ];

        $response = $this->postJson('/api/files/upload', $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'File uploaded successfully!',
            ])
            ->assertJsonStructure([
                'file' => [
                    'user_id',
                    'file_name',
                    'file_path',
                    'comment',
                    'expiration_date',
                    'views_count',
                    'updated_at',
                    'created_at',
                    'id',
                ],
            ]);
    }

    public function test_user_can_upload_file_fails_with_max_size_file(): void
    {
        User::where('email', 'johnTest8@example.com')->delete();

        $user = User::factory()->create([
            'email' => 'johnTest8@example.com',
        ]);

        $file = UploadedFile::fake()->create('test_document.pdf', 8000, 'application/pdf');

        $requestData = [
            'user_id' => $user->id,
            'file' => $file,
            'comment' => 'Test file comment',
            'expiration_date' => now()->addDays(5)->toDateString(),
        ];

        $response = $this->postJson('/api/files/upload', $requestData);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    public function test_user_can_upload_file_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/files/upload');

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    public function test_user_can_upload_file_fails_with_invalid_user_id(): void
    {
        $file = UploadedFile::fake()->create('test_document.pdf', 500, 'application/pdf');

        $requestData = [
            'user_id' => '00',
            'file' => $file,
            'comment' => 'Test file comment',
            'expiration_date' => now()->addDays(5)->toDateString(),
        ];

        $response = $this->postJson('/api/files/upload', $requestData);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'User not found.',
            ]);
    }

    public function test_user_can_upload_file_fails_with_empty_user_id(): void
    {
        $file = UploadedFile::fake()->create('test_document.pdf', 500, 'application/pdf');

        $requestData = [
            'user_id' => '',
            'file' => $file,
            'comment' => 'Test file comment',
            'expiration_date' => now()->addDays(5)->toDateString(),
        ];

        $response = $this->postJson('/api/files/upload', $requestData);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'error' => 'User ID is required.',
            ]);
    }
}
