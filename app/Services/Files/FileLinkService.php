<?php

namespace App\Services\Files;

use App\Enums\FileLinkType;
use App\Models\File;
use App\Models\FileLink;

class FileLinkService
{
    public function createLink(File $file, string $type): FileLink
    {
        return FileLink::create([
            'file_id' => $file->id,
            'type' => $type,
            'token' => FileLink::generateToken(),
            'is_active' => true,
            'views_count' => 0,
        ]);
    }

    public function getFileByToken(string $token): ?File
    {
        $link = FileLink::where('token', $token)
            ->where('is_active', true)
            ->first();

        if (!$link) {
            return null;
        }

        $link->increment('views_count');

        $file = $link->file;
        $file->increment('views_count');

        if ($link->type === FileLinkType::TEMPORARY) {
            $link->deactivate();
        }
        return $link->file;
    }
}
