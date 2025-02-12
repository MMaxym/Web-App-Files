<?php

namespace App\Http\Controllers;

use App\Services\Files\FileService;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function showMainPage()
    {
        $files = $this->fileService->getUserFiles();
        $countFiles = $this->fileService->getUserFilesCount();
        return view('main', compact('files', 'countFiles'));
    }
}
