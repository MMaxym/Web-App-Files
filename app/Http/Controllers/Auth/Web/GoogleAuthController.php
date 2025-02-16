<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Controller;
use App\Services\Auth\GoogleAuthService;

class GoogleAuthController extends Controller
{
    protected $googleAuthService;

    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    public function redirectToGoogle()
    {
        return $this->googleAuthService->redirectToGoogle();
    }

    public function handleGoogleCallback()
    {
        try {
            return $this->googleAuthService->handleGoogleCallback();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors($e->getMessage());
        }
    }
}
