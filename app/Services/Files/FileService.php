<?php

namespace App\Services\Files;

use App\Models\File;
use Illuminate\Http\Request;

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
}
