<?php

namespace Src\Auth\DTO;

use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

class ChangePasswordDTO extends Data
{
    public function __construct(
        #[Password(min: 8)]
        #[Confirmed]
        public string $password,
        public string $password_confirmation
    ) {
    }

    public static function messages(): array
    {
        return [
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}
