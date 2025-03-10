<?php

declare(strict_types=1);

namespace App\Http\Controllers\Files\Web;

use App\Http\Controllers\Controller;
use App\Services\Files\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $response = $this->fileService->uploadFile($request, $userId);

        return response()->json($response, isset($response['error']) ? 400 : 201);
    }

    public function destroy($id): JsonResponse
    {
        $userId = auth()->id();
        $response = $this->fileService->deleteFile($userId, $id);
        return response()->json($response);
    }

    public function getFileDetails($fileId): JsonResponse
    {
        $result = $this->fileService->getFileDetails($fileId);
        return response()->json($result);
    }
}
