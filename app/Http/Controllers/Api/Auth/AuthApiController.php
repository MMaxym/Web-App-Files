<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthApiController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->registerUser($request);

        if (isset($result['errors'])) {
            return response()->json([
                'success' => false,
                'errors' => $result['errors']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->authenticateUser($request);

        if (isset($result['errors'])) {
            return response()->json([
                'success' => false,
                'errors' => $result['errors']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'token' => $result['token'],
            'user' => $result['user']
        ], Response::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $this->authService->logoutUser($token);

        return response()->json([
            'success' => true,
            'message' => 'Logout successful!'
        ], Response::HTTP_OK);
    }
}
