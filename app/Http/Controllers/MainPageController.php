<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\FileLinks\FileLinkService;
use App\Services\Files\FileService;
use Illuminate\View\View;

class MainPageController extends Controller
{
    protected $fileService;
    protected $fileLinkService;

    public function __construct(FileService $fileService, FileLinkService $fileLinkService)
    {
        $this->fileService = $fileService;
        $this->fileLinkService = $fileLinkService;
    }

    public function showMainPage(): View
    {
        $userId = auth()->id();

        $files = $this->fileService->getUserFiles($userId);
        $countFiles = $this->fileService->getUserFilesCount($userId);
        $totalViews = $this->fileService->getTotalViews($userId);
        $existingFilesCount = $this->fileService->getExistingFilesCount($userId);
        $deletedFilesCount = $this->fileService->getDeletedFilesCount($userId);

        $totalDisposableLinks = $this->fileLinkService->getTotalDisposableLinksCount($userId);
        $usedDisposableLinks = $this->fileLinkService->getUsedDisposableLinksCount($userId);

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
