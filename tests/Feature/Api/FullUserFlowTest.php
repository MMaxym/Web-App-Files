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
    public function test_full_user_flow(): void
    {
        //----------Registration----------
        User::where('email', 'fullTest@exaple.com')->delete();

        $requestDataRegister = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'fullTest@exaple.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '380974561207',
        ];

        $responseRegister = $this->postJson('/api/auth/register', $requestDataRegister);

        $responseRegister->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful!',
            ]);


        //----------Authorization----------
        $requestDataLogin = [
            'email' => 'fullTest@exaple.com',
            'password' => 'password123',
        ];

        $responseLogin = $this->postJson('/api/auth/login', $requestDataLogin);

        $responseLogin->assertStatus(200)
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

        $responseData = $responseLogin->json();
        $token = $responseData['token'];
        $this->assertIsString($token);



        //----------View_User_Files----------
        $user_id = $responseLogin->json('user.id');

        File::factory(5)->create([
            'user_id' =>  $user_id,
        ]);

        $responseUserFiles = $this->get('api/users/'. $user_id.'/files');

        $responseUserFiles->assertStatus(200)
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


        //----------View_File_Details----------
        $fileDetails = File::factory()->create([
            'user_id' =>  $user_id,
        ]);

        $responseFileDetails = $this->get('/api/files/' . $fileDetails->id);

        $responseFileDetails->assertStatus(200)
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


        //----------View_Total_Views----------
        $responseTotalViews = $this->get('api/users/'.$user_id.'/files/total-views');

        $responseTotalViews->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'total_views' => intval($responseTotalViews->json('total_views')),
            ]);


        //----------View_Total_Count_Files----------
        $responseTotalCount = $this->get('api/users/'.$user_id.'/files/total-count');

        $responseTotalCount->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'files_count' => intval($responseTotalCount->json('files_count')),
            ]);


        //----------View_Existing_Count_Files----------
        $responseExistingCount = $this->get('api/users/'.$user_id.'/files/existing-count');

        $responseExistingCount->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'existing_files_count' => intval($responseExistingCount->json('existing_files_count')),
            ]);


        //----------View_Deleted_Count_Files----------
        File::factory(5)->create([
            'user_id' => $user_id,
            'deleted_at' => now(),
        ]);

        $responseDeletedCount = $this->get('api/users/'.$user_id.'/files/deleted-count');

        $responseDeletedCount->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'deleted_files_count' => intval($responseDeletedCount->json('deleted_files_count')),
            ]);


        //----------View_Disposable_Links_Count----------
        $fileDisposableLinks = File::factory()->create([
            'user_id' => $user_id,
        ]);

        FileLink::factory(10)->create([
            'file_id' => $fileDisposableLinks->id,
        ]);

        $responseDisposableLinks = $this->get('api/users/'.$user_id.'/file-links/disposable-links-count');

        $responseDisposableLinks->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'disposable_links_count' => intval($responseDisposableLinks->json('disposable_links_count')),
            ]);


        //----------View_Used_Disposable_Links_Count----------
        $responseUsedDisposableLinks = $this->get('api/users/'.$user_id.'/file-links/used-disposable-links-count');

        $responseUsedDisposableLinks->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'used_disposable_links_count' => intval($responseUsedDisposableLinks->json('used_disposable_links_count')),
            ]);


        //----------Add_New_File----------
        $fileUpload = UploadedFile::fake()->create('test_document_12345.pdf', 1000, 'application/pdf');

        $requestDataUploadFile = [
            'user_id' => $user_id,
            'file' => $fileUpload,
            'comment' => 'Test file comment for full test flow',
            'expiration_date' => now()->addDays(5)->toDateString(),
        ];

        $responseUploadFile = $this->postJson('/api/files/upload', $requestDataUploadFile);

        $responseUploadFile->assertStatus(200)
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



        //----------Generate_Temporary_Link----------
        $file_id_for_generate_links = $responseUploadFile->json('file.id');

        $requestGenerateTemporaryLink = [
            'type' => 'temporary',
        ];

        $responseGenerateTemporaryLink = $this->postJson('api/files/' . $file_id_for_generate_links . '/generate-link', $requestGenerateTemporaryLink);

        $responseGenerateTemporaryLink->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File link generated successfully.',
            ])
            ->assertJsonStructure([
                'link',
            ]);



        //----------Generate_Public_Link----------
        $requestGeneratePublicLink = [
            'type' => 'public',
        ];

        $responseGeneratePublicLink = $this->postJson('api/files/' . $file_id_for_generate_links . '/generate-link', $requestGeneratePublicLink);

        $responseGeneratePublicLink->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File link generated successfully.',
            ])
            ->assertJsonStructure([
                'link',
            ]);



        //----------Delete_File----------
        $responseDeleteFile = $this->delete('api/users/' . $user_id . '/files/' . $file_id_for_generate_links);

        $responseDeleteFile->assertStatus(200)
            ->assertJson([
                'message' => 'File moved to archive',
            ]);



        //----------Update_User_Personal_Information----------
        $user_first_name = $responseLogin->json('user.first_name');
        $user_last_name = $responseLogin->json('user.last_name');
        $user_email = $responseLogin->json('user.email');
        $user_phone = $responseLogin->json('user.phone');

        $requestDataUpdateUser = [
            'first_name' => $user_first_name . '_update',
            'last_name' => $user_last_name . '_update',
            'email' => $user_email,
            'phone' => $user_phone,
        ];

        $responseUpdateUser = $this->putJson('/api/users/' . $user_id, $requestDataUpdateUser, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseUpdateUser->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User information updated successfully',
            ]);



        //----------Logout----------
        $responseLogout = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseLogout->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful!',
            ]);
    }
}
