<?php

declare(strict_types=1);

namespace Tests\Feature\Api\FileLinks;

use App\Models\File;
use App\Models\User;
use App\Models\FileLink;
use Illuminate\Foundation\Testing\TestCase;

class FileLinkUsedDisposableLinksCountTest extends TestCase
{
    public function test_user_can_get_file_link_used_disposable_links_count(): void
    {
        $user = User::factory()->create();

        $file = File::factory()->create([
            'user_id' => $user->id,
        ]);

        FileLink::factory(10)->create([
            'file_id' => $file->id,
        ]);

        $response = $this->get('api/users/'.$user->id.'/file-links/used-disposable-links-count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'used_disposable_links_count' => intval($response->json('used_disposable_links_count')),
            ]);
    }

    public function test_user_can_get_file_link_used_disposable_links_count_fails_invalid_id(): void
    {
        $response = $this->get('api/users/00/file-links/used-disposable-links-count');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'User not found.',
            ]);
    }
}
