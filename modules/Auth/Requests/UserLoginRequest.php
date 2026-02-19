<?php

declare(strict_types=1);

namespace Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }
}
