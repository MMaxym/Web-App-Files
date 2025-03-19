<?php

declare(strict_types=1);

namespace App\Http\Controllers\FileLinks\Web;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\FileLinks\FileLinkService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileLinkController extends Controller
{
    protected $fileLinkService;

    public function __construct(FileLinkService $fileLinkService)
    {
        $this->fileLinkService = $fileLinkService;
    }

    public function generateLink(Request $request, $id): JsonResponse
    {
        $file = File::findOrFail($id);
        $type = $request->input('type');

        $link = $this->fileLinkService->createLink($file, $type);

        return response()->json(['url' => url("/files/view/{$file->file_name}/{$link->token}")]);
    }

    public function viewFile($fileName, $token): BinaryFileResponse
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
