<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Api;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ForgotPasswordApiController extends Controller
{
    protected $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        $data = $request->only('email');
        $response = $this->forgotPasswordService->sendResetLinkEmail($data);

        return response()->json([
            'success' => $response['status'] === 'success',
            'message' => $response['message'],
        ], $response['http_code']);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->only('email', 'password', 'password_confirmation', 'token');
        $response = $this->forgotPasswordService->resetPassword($data);

        return response()->json([
            'success' => $response['status'] === 'success',
            'message' => $response['message'],
        ], $response['http_code']);
    }
}
