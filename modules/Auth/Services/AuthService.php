<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Modules\Auth\DTO\UserRegisterDTO;
use modules\Users\Models\User;

class AuthService
{
    public function create(UserRegisterDTO $userRegisterDTO): User
    {
        $user = new User();
        $user->name = $userRegisterDTO->name;
        $user->email = $userRegisterDTO->email;
        $user->password = $userRegisterDTO->password;

        $user->save();
        return $user;
    }
}
