<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function registration(Request $request): RedirectResponse
    {
        $result = $this->authService->registerUser($request->all());

        if (isset($result['errors'])) {
            return redirect()->back()->withErrors($result['errors'])->withInput();
        }

        Auth::login($result['user']);
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function login(Request $request): RedirectResponse
    {
        $result = $this->authService->authenticateUser($request->all());

        if (isset($result['errors'])) {
            return back()->withErrors($result['errors'])->withInput();
        }

        session(['jwt_token' => $result['token']]);
        $request->session()->regenerate();

        return redirect()->route('main')->with('success', 'Authorization successful!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $token = session('jwt_token');
        $this->authService->logoutUser($token);

        session()->forget('jwt_token');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout successful!');
    }
}
