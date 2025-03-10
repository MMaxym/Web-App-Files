<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordService
{
    public function sendResetLinkEmail($data): array
    {
        $validator = Validator::make($data, [
            'email' => [
                'required',
                'email',
            ],
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => $validator->errors(),
                'http_code' => Response::HTTP_BAD_REQUEST,
            ];
        }

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'User with this email does not exist.',
                'http_code' => Response::HTTP_NOT_FOUND,
            ];
        }

        $response = Password::sendResetLink($data);

        return $response == Password::RESET_LINK_SENT
            ? [
                'status' => 'success',
                'message' => 'Password reset link has been sent to your email address.',
                'http_code' => Response::HTTP_OK,
            ]
            : [
                'status' => 'error',
                'message' => 'Failed to send the password reset link. Please try again.',
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE,
            ];
    }

    public function resetPassword($data): array
    {
        $validator = Validator::make($data, [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6',
            ],
            'token' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => $validator->errors(),
                'http_code' => Response::HTTP_BAD_REQUEST,
            ];
        }

        $response = Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $response == Password::PASSWORD_RESET
            ? [
                'status' => 'success',
                'message' => 'Password updated successfully.',
                'http_code' => Response::HTTP_OK,
            ]
            : [
                'status' => 'error',
                'message' => trans($response),
                'http_code' => Response::HTTP_BAD_REQUEST,
            ];
    }
}
