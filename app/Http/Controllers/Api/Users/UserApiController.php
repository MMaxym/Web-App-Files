<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserApiController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->userService->updateUser($request->validated(), $id);

        return response()->json([
            'success' => true,
            'message' => 'User information updated successfully',
            'user' => $user,
        ], Response::HTTP_OK);
    }
}
