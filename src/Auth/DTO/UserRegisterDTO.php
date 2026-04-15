<?php

namespace Src\Auth\DTO;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UserRegisterDTO extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,
        #[Max(255)]
        #[Email]
        #[Unique('users', 'email')]
        public string $email,
        #[Password(min: 8)]
        #[Confirmed]
        public string $password,
        public string $password_confirmation,
    ) {

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
