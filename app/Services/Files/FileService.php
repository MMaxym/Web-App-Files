<?php

namespace App\Services\Files;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120',
            'comment' => 'nullable|string|max:500',
            'expiration_date' => 'nullable|date|after_or_equal:today',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $uniqueFilePath = "uploads/" . uniqid() . "_" . $fileName;

            $file->storeAs($uniqueFilePath);

            $uploadedFile = File::create([
                'user_id' => auth()->id(),
                'file_name' => $fileName,
                'file_path' => $uniqueFilePath,
                'comment' => $request->comment,
                'expiration_date' => $request->expiration_date,
                'views_count' => 0,
            ]);

            return [
                'message' => 'File uploaded successfully!',
                'file' => $uploadedFile
            ];
        }

        return ['error' => 'No file uploaded'];
    }

    public function getUserFiles()
    {
        $userId = auth()->id();

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

    public function getUserFilesCount(): int
    {
        $userId = auth()->id();
        return File::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->count();
    }

    public function deleteFile($fileId)
    {
        $file = File::where('user_id', auth()->id())->findOrFail($fileId);
        $file->delete();
        return ['message' => 'File moved to archive'];
    }

    public function getTotalViews(): int
    {
        $userId = auth()->id();
        return File::where('user_id', $userId)
        ->sum('views_count');
    }

    public function getExistingFilesCount(): int
    {
        $userId = auth()->id();
        return File::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->count();
    }

    public function getDeletedFilesCount(): int
    {
        $userId = auth()->id();
        return File::withTrashed()
            ->where('user_id', $userId)
            ->whereNotNull('deleted_at')
            ->count();
    }

    public function getFileDetails($fileId)
    {
        $file = File::find($fileId);
        if ($file) {
            return [
                'success' => true,
                'file' => $file,
            ];
        }
        return ['success' => false];
    }
}
