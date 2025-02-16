<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function registerUser($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $user = User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
        ]);

        return ['user' => $user];
    }

    public function authenticateUser($credentials)
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return ['errors' => ['email' => 'Email not found']];
        }
        if (!Hash::check($credentials['password'], $user->password)) {
            return ['errors' => ['password' => 'Incorrect password']];
        }

        $token = JWTAuth::fromUser($user);
        Auth::login($user);

        return ['token' => $token, 'user' => $user];
    }

    public function logoutUser($token)
    {
        if ($token) {
            try {
                JWTAuth::parseToken()->invalidate();
            } catch (JWTException $e) {
                return ['error' => 'Failed to log out.'];
            }
        }
        return ['message' => 'You have been logged out.'];
    }
}
