<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Services\Files\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(Request $request)
    {
        $response = $this->fileService->uploadFile($request);

        return response()->json($response, isset($response['error']) ? 400 : 201);
    }
}
