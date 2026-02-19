<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\DTO\UserRegisterDTO;
use modules\Users\Models\User;

class AuthService
{
    public function registrate(UserRegisterDTO $userRegisterDTO): User
    {
        $user = new User();
        $user->name = $userRegisterDTO->name;
        $user->email = $userRegisterDTO->email;
        $user->password = $userRegisterDTO->password;
        $user->save();

        Auth::login($user);
        return $user;
    }
}
