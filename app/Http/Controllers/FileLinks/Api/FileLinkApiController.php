<?php

namespace App\Http\Controllers\FileLinks\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileLink;
use App\Models\User;
use App\Services\FileLinks\FileLinkService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\FileLinkType;
use Illuminate\Support\Facades\Validator;

class FileLinkApiController extends Controller
{
    protected $fileLinkService;

    public function __construct(FileLinkService $fileLinkService)
    {
        $this->fileLinkService = $fileLinkService;
    }

    public function generateLink(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!in_array($value, [FileLinkType::PUBLIC->value, FileLinkType::TEMPORARY->value])) {
                    $fail("Invalid link type. Allowed values: 'public', 'temporary'.");
                }
            }]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = File::find($id);
        if (!$file) {
            return response()->json([
                'success' => false,
                'error' => 'File not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $fileLink = $this->fileLinkService->createLink($file, $request->type);

        return response()->json([
            'success' => true,
            'message' => 'File link generated successfully.',
            'link' => url("/api/files/view/{$file->file_name}/{$fileLink->token}")
        ], Response::HTTP_CREATED);
    }

    public function viewFileByToken(string $fileName, string $token)
    {
        $file = $this->fileLinkService->getFileByToken($token);

        if (!$file || $file->file_name !== $fileName) {
            abort(404);
        }

        $filePath = storage_path("app/private/{$file->file_path}");

        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->file($filePath);
    }

    public function getTotalDisposableLinksCount($userId)
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ],Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $count = $this->fileLinkService->getTotalDisposableLinksCount($userId);

        return response()->json([
            'success' => true,
            'disposable_links_count' => $count,
        ], Response::HTTP_OK);
    }

    public function getUsedDisposableLinksCount($userId)
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'error' => 'User ID is required.'
            ],Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $count = $this->fileLinkService->getUsedDisposableLinksCount($userId);

        return response()->json([
            'success' => true,
            'used_disposable_links_count' => $count,
        ], Response::HTTP_OK);
    }
}
