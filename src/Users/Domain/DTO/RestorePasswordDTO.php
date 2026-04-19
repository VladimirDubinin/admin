<?php

namespace App\Users\Domain\DTO;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class RestorePasswordDTO extends Data
{
    public function __construct(
        #[Email]
        #[Max(255)]
        #[Exists('users', 'email')]
        public string $email
    ) {
    }

    public static function messages(): array
    {
        return [
            'email.exists' => 'Выбранный адрес электронной почты недействителен.',
        ];
    }
}
