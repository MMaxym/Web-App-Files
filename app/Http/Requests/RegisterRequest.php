<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:6',
            ],
            'first_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'min:10',
            ],
        ];
    }
}
