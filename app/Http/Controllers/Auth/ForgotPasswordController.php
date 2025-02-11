<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $result = $this->forgotPasswordService->sendResetLinkEmail($request->only('email'));

        if ($result['status'] == 'success') {
            return back()->with('success', $result['message']);
        }

        return back()->withErrors(['email' => $result['message']])->withInput();
    }

    public function reset(Request $request)
    {
        $result = $this->forgotPasswordService->resetPassword($request->only('email', 'password', 'password_confirmation', 'token'));

        if ($result['status'] == 'success') {
            return redirect()->route('login')->with('success', $result['message']);
        }

        return back()->withErrors(['email' => $result['message']]);
    }
}
