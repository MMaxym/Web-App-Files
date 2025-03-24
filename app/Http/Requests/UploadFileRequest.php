<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:5120',
            ],
            'comment' => [
                'nullable',
                'string',
                'max:500',
            ],
            'expiration_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
        ];
    }
}
