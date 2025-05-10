<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $userId = auth()->id();

        $user = $this->userService->updateUser($request->validated(), $userId);

        return response()->json([
            'message' => 'User information updated successfully.',
            'user' => $user,
        ], 200);
    }
}
