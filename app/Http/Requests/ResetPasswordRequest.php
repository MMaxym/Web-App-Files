<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
        ];
    }
}
