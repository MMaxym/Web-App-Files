<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class AuthApiController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse
    {
        $result = $this->authService->registerUser($request->all());

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

    public function login(Request $request): JsonResponse
    {
        $result = $this->authService->authenticateUser($request->all());

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
