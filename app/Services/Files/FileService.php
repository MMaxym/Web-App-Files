<?php

declare(strict_types=1);

namespace App\Services\Files;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class FileService
{
    public function uploadFile(Request $request, $userId): array
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:5120',
            ],
            'comment' => [
                'nullable',
                'string',
                'max:500',
            ],
            'expiration_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $uniqueFilePath = "uploads/" . uniqid() . "_" . $fileName;

            $file->storeAs($uniqueFilePath);

            $uploadedFile = File::create([
                'user_id' => $userId,
                'file_name' => $fileName,
                'file_path' => $uniqueFilePath,
                'comment' => $request->comment,
                'expiration_date' => $request->expiration_date,
                'views_count' => 0,
            ]);

            return [
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file' => $uploadedFile,
            ];
        }

        return [
            'success' => false,
            'error' => 'No file uploaded',
        ];
    }

    public function getUserFiles($userId): Collection
    {
        return File::where('user_id', $userId)
            ->select('id', 'file_name', 'file_path', 'comment', 'expiration_date', 'views_count', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($file) {
                return [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'file_path' => $file->file_path,
                    'comment' => $file->comment ?? 'No comment',
                    'expiration_date' => $file->expiration_date ? $file->expiration_date->format('d.m.Y') : '-',
                    'views_count' => $file->views_count,
                    'created_at' => $file->created_at->format('d.m.Y'),
                ];
            });
    }

    public function getUserFilesCount($userId): int
    {
        return File::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->count();
    }

    public function getTotalViews($userId): int
    {
        return (int) File::where('user_id', $userId)
        ->sum('views_count');
    }

    public function getExistingFilesCount($userId): int
    {
        return File::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->count();
    }

    public function getDeletedFilesCount($userId): int
    {
        return File::withTrashed()
            ->where('user_id', $userId)
            ->whereNotNull('deleted_at')
            ->count();
    }

    public function getFileDetails($fileId): array
    {
        $file = File::find($fileId);
        if ($file) {
            return [
                'success' => true,
                'file' => $file,
            ];
        }
        return [
            'success' => false,
        ];
    }

    public function deleteFile($userId, $fileId): array
    {
        $file = File::where('user_id', $userId)->findOrFail($fileId);
        $file->delete();
        return [
            'message' => 'File moved to archive',
        ];
    }
}
