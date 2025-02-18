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
        $userId = auth()->id();

        $files = $this->fileService->getUserFiles($userId);
        $countFiles = $this->fileService->getUserFilesCount($userId);
        $totalViews = $this->fileService->getTotalViews($userId);
        $existingFilesCount = $this->fileService->getExistingFilesCount($userId);
        $deletedFilesCount = $this->fileService->getDeletedFilesCount($userId);

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
