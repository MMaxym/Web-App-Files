<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function updateUser(array $data, int $userId): User
    {
        $user = User::findOrFail($userId);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        return $user;
    }
}
