<?php

namespace Modules\Auth\DTO;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UserRegisterDTO extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,
        public string $email,
        #[Password(min: 8)]
        public string $password,
        public string $password_confirmation,
    ) {

    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|confirmed|min:8',
        ];
    }

    public static function messages(): array
    {
        return [
            'email.unique' => 'Этот адрес электронной почты уже занят',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}
