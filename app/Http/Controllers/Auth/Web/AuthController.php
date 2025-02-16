<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registration(Request $request)
    {
        $result = $this->authService->registerUser($request->all());

        if (isset($result['errors'])) {
            return redirect()->back()->withErrors($result['errors'])->withInput();
        }

        Auth::login($result['user']);
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $result = $this->authService->authenticateUser($request->all());

        if (isset($result['errors'])) {
            return back()->withErrors($result['errors'])->withInput();
        }

        session(['jwt_token' => $result['token']]);
        $request->session()->regenerate();

        return redirect()->route('main')->with('success', 'Authorization successful!');
    }

    public function logout(Request $request)
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
