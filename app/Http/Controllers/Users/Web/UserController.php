<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users\Web;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->updateUser($request->all(), Auth::id());

            return response()->json([
                'message' => 'User information updated successfully.',
                'user' => $user,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
