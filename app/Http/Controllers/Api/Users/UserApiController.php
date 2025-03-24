<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserApiController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $token = $request->header('Authorization');

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthenticated',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = $this->userService->updateUser($request->all(), $id);

            return response()->json([
                'success' => true,
                'message' => 'User information updated successfully',
                'user' => $user,
            ], Response::HTTP_OK);

        }
        catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], Response::HTTP_BAD_REQUEST);

        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong. Please try again later.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
