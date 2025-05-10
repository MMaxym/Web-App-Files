<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordApiController extends Controller
{
    protected $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        $response = $this->forgotPasswordService->sendResetLinkEmail($request);

        return response()->json([
            'success' => $response['status'] === 'success',
            'message' => $response['message'],
        ], $response['http_code']);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $response = $this->forgotPasswordService->resetPassword($request);

        return response()->json([
            'success' => $response['status'] === 'success',
            'message' => $response['message'],
        ], $response['http_code']);
    }
}
