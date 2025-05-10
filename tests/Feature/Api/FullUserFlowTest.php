<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\File;
use App\Models\FileLink;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestCase;

class FullUserFlowTest extends TestCase
{
    private string $token;
    private int $userId;

    public function test_full_user_flow(): void
    {
        $this->registerUser();
        $this->loginUser();
        $this->viewUserFiles();
        $this->viewFileDetails();
        $this->viewTotalViews();
        $this->viewTotalFileCounts();
        $this->viewExistingFilesCount();
        $this->viewDeletedFilesCount();
        $this->viewDisposableLinksCounts();
        $this->viewUsedDisposableLinksCounts();
        $fileId = $this->uploadFile();
        $this->generateTemporaryLink($fileId);
        $this->generatePublicLink($fileId);
        $this->deleteFile($fileId);
        $this->updateUserInfo();
        $this->logoutUser();
    }

    private function registerUser(): void
    {
        User::where('email', 'fullTest@example.com')->delete();

        $requestData = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'fullTest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '380974561207',
        ];

        $response = $this->postJson('/api/auth/register', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful!',
            ]);
    }

    private function loginUser(): void
    {
        $requestData = [
            'email' => 'fullTest@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/auth/login', $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful!',
            ])
            ->assertJsonStructure([
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'first_name',
                    'last_name',
                    'phone',
                    'google_id',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $data = $response->json();
        $this->token = $data['token'];
        $this->userId = $data['user']['id'];
    }

    private function viewUserFiles(): void
    {
        File::factory(5)->create([
            'user_id' => $this->userId,
        ]);

        $response = $this->get('api/users/' . $this->userId . '/files');

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

    private function viewFileDetails(): void
    {
        $file = File::factory()->create([
            'user_id' => $this->userId,
        ]);

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

    private function viewTotalViews(): void
    {
        $response = $this->get('api/users/'.$this->userId.'/files/total-views');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'total_views' => intval($response->json('total_views')),
            ]);
    }

    private function viewTotalFileCounts(): void
    {
        $response = $this->get('api/users/' .$this->userId. '/files/total-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'files_count' => intval($response->json('files_count')),
            ]);
    }

    private function viewExistingFilesCount(): void
    {
        $response = $this->get('api/users/'. $this->userId .'/files/existing-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'existing_files_count' => intval($response->json('existing_files_count')),
            ]);
    }

    private function viewDeletedFilesCount(): void
    {
        File::factory(5)->create([
            'user_id' => $this->userId,
            'deleted_at' => now(),
        ]);

        $response = $this->get('api/users/' . $this->userId . '/files/deleted-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'deleted_files_count' => intval($response->json('deleted_files_count')),
            ]);
    }

    private function viewDisposableLinksCounts(): void
    {
        $file = File::factory()->create([
            'user_id' => $this->userId,
        ]);

        FileLink::factory(10)->create([
            'file_id' => $file->id,
        ]);

        $response= $this->get('api/users/' . $this->userId . '/file-links/disposable-links-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'disposable_links_count' => intval($response->json('disposable_links_count')),
            ]);
    }

    private function viewUsedDisposableLinksCounts(): void
    {
        $response = $this->get('api/users/' . $this->userId . '/file-links/used-disposable-links-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'used_disposable_links_count' => intval($response->json('used_disposable_links_count')),
            ]);
    }

    private function uploadFile(): int
    {
        $file = UploadedFile::fake()->create('test_document_12345.pdf', 1000, 'application/pdf');

        $requestData = [
            'user_id' => $this->userId,
            'file' => $file,
            'comment' => 'Test file comment for full test flow',
            'expiration_date' => now()->addDays(5)->toDateString(),
        ];

        $response= $this->postJson('/api/files/upload', $requestData);

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

        return $response->json('file.id');
    }

    private function generateTemporaryLink(int $fileId): void
    {
        $requestData = [
            'type' => 'temporary',
        ];

        $response = $this->postJson('api/files/' . $fileId . '/generate-link', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File link generated successfully.',
            ])
            ->assertJsonStructure([
                'link',
            ]);
    }

    private function generatePublicLink(int $fileId): void
    {
        $requestData = [
            'type' => 'public',
        ];

        $response = $this->postJson('api/files/' . $fileId . '/generate-link', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File link generated successfully.',
            ])
            ->assertJsonStructure([
                'link',
            ]);
    }

    private function deleteFile(int $fileId): void
    {
        $response = $this->delete('api/users/' . $this->userId . '/files/' . $fileId);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'File moved to archive',
            ]);
    }

    private function updateUserInfo(): void
    {
        $requestData = [
            'first_name' => 'Test_user_updated',
            'last_name' => 'Test_user_updated',
            'email' => 'fullTest@example.com',
            'phone' => '380974561207',
        ];

        $response = $this->putJson('/api/users/' . $this->userId, $requestData, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User information updated successfully',
            ]);
    }

    private function logoutUser(): void
    {
        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful!',
            ]);
    }
}
