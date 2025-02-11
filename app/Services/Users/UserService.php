<?php
namespace App\Services\Users;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function updateUser($data, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
        ]);

        if ($validated->fails()) {
            throw new ValidationException($validated);
        }

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        return $user;
    }
}
