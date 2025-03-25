<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function registerUser(RegisterRequest $request): array
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
        ]);

        return [
            'user' => $user,
        ];
    }

    public function authenticateUser(LoginRequest $request): array
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return [
                'errors' => [
                    'email' => 'Email not found',
                ],
            ];
        }
        if (!Hash::check($credentials['password'], $user->password)) {
            return [
                'errors' => [
                    'password' => 'Incorrect password',
                ],
            ];
        }

        $token = JWTAuth::fromUser($user);
        Auth::login($user);

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logoutUser($token): array
    {
        if ($token) {
            try {
                JWTAuth::parseToken()->invalidate();
            }
            catch (JWTException $e) {
                return [
                    'error' => 'Failed to log out.',
                ];
            }
        }
        return [
            'message' => 'You have been logged out.',
        ];
    }
}
