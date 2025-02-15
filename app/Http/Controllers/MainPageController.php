<?php

namespace App\Http\Controllers;

use App\Services\Files\FileService;
use App\Services\Files\FileLinkService;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    protected $fileService;
    protected $fileLinkService;

    public function __construct(FileService $fileService, FileLinkService $fileLinkService)
    {
        $this->fileService = $fileService;
        $this->fileLinkService = $fileLinkService;
    }

    public function showMainPage()
    {
        $files = $this->fileService->getUserFiles();
        $countFiles = $this->fileService->getUserFilesCount();
        $totalViews = $this->fileService->getTotalViews();
        $existingFilesCount = $this->fileService->getExistingFilesCount();
        $deletedFilesCount = $this->fileService->getDeletedFilesCount();

        $totalDisposableLinks = $this->fileLinkService->getTotalDisposableLinksCount();
        $usedDisposableLinks = $this->fileLinkService->getUsedDisposableLinksCount();

        return view('main', compact(
            'files',
            'countFiles',
            'totalViews',
            'existingFilesCount',
            'deletedFilesCount',
            'totalDisposableLinks',
            'usedDisposableLinks'
        ));
    }
}
