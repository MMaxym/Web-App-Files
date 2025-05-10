<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    protected $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function showLinkRequestForm(): View
    {
        return view('auth.passwords.email');
    }

    public function showResetForm(Request $request, $token = null): View
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request): RedirectResponse
    {
        $result = $this->forgotPasswordService->sendResetLinkEmail($request);

        if ($result['status'] == 'success') {
            return back()->with('success', $result['message']);
        }
        return back()->withErrors(['email' => $result['message']])->withInput();
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $result = $this->forgotPasswordService->resetPassword($request);

        if ($result['status'] == 'success') {
            return redirect()->route('login')->with('success', $result['message']);
        }
        return back()->withErrors(['email' => $result['message']]);
    }
}
