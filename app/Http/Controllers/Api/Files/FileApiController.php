<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Files;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Models\User;
use App\Services\Files\FileService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class FileApiController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(UploadFileRequest $request): JsonResponse
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->fileService->uploadFile($request, $userId);

        if ($result['success']) {
            return response()->json($result, Response::HTTP_OK);
        }
        else {
            return response()->json($result, Response::HTTP_BAD_REQUEST);
        }
    }

    public function getUserFiles($userId): JsonResponse
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $files = $this->fileService->getUserFiles($userId);

        return response()->json([
            'success' => true,
            'files' => $files,
        ], Response::HTTP_OK);
    }

    public function getUserFilesCount($userId): JsonResponse
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $count = $this->fileService->getUserFilesCount($userId);

        return response()->json([
            'success' => true,
            'files_count' => $count,
        ], Response::HTTP_OK);
    }

    public function getTotalViews($userId): JsonResponse
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $views = $this->fileService->getTotalViews($userId);

        return response()->json([
            'success' => true,
            'total_views' => $views,
        ], Response::HTTP_OK);
    }

    public function getExistingFilesCount($userId): JsonResponse
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $count = $this->fileService->getExistingFilesCount($userId);

        return response()->json([
            'success' => true,
            'existing_files_count' => $count,
        ], Response::HTTP_OK);
    }

    public function getDeletedFilesCount($userId): JsonResponse
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $count = $this->fileService->getDeletedFilesCount($userId);

        return response()->json([
            'success' => true,
            'deleted_files_count' => $count,
        ], Response::HTTP_OK);
    }

    public function getFileDetails($fileId): JsonResponse
    {
        if (!$fileId) {
            return response()->json([
                'success' => false,
                'error' => 'Fail ID is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = File::find($fileId);

        if (!$file) {
            return response()->json([
                'success' => false,
                'error' => 'File not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->fileService->getFileDetails($fileId);

        if ($result['success'])
        {
            return response()->json($result, Response::HTTP_OK);
        }
        else {
            return response()->json($result, Response::HTTP_NOT_FOUND);
        }
    }

    public function delete($userId, $fileId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $file = File::where('user_id', $userId)->find($fileId);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->fileService->deleteFile($userId, $fileId);

        return response()->json($result, Response::HTTP_OK);
    }
}
