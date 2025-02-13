<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Services\Files\FileLinkService;
use App\Models\File;
use Illuminate\Http\Request;

class FileLinkController extends Controller
{
    protected $fileLinkService;

    public function __construct(FileLinkService $fileLinkService)
    {
        $this->fileLinkService = $fileLinkService;
    }

    public function generateLink(Request $request, $id)
    {
        $file = File::findOrFail($id);
        $type = $request->input('type');

        $link = $this->fileLinkService->createLink($file, $type);

        return response()->json(['url' => url("/files/view/{$file->file_name}/{$link->token}")]);
    }

    public function viewFile($fileName, $token)
    {
        $file = $this->fileLinkService->getFileByToken($token);

        if (!$file || $file->file_name !== $fileName) {
            abort(404);
        }

        $filePath = storage_path("app/private/{$file->file_path}");

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    }
}
