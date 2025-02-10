<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordService
{
    public function sendResetLinkEmail($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'message' => $validator->errors()];
        }

        $response = Password::sendResetLink($data);

        return $response == Password::RESET_LINK_SENT
            ? ['status' => 'success', 'message' => 'Password reset link has been sent to your email address.']
            : ['status' => 'error', 'message' => 'Failed to send the password reset link. Please try again.'];
    }

    public function resetPassword($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'message' => $validator->errors()];
        }

        $response = Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $response == Password::PASSWORD_RESET
            ? ['status' => 'success', 'message' => 'Password updated successfully.']
            : ['status' => 'error', 'message' => trans($response)];
    }
}
