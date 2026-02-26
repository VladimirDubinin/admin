<?php

namespace Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'email' => ['sometimes', 'email'],
            'roles' => ['integer'],
        ];
    }
}
