<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\DTO\UserRegisterDTO;
use modules\Users\Models\User;

class AuthService
{
    public function create(UserRegisterDTO $userRegisterDTO): User
    {
        $user = new User();
        $user->name = $userRegisterDTO->name;
        $user->email = $userRegisterDTO->email;
        $user->password = Hash::make($userRegisterDTO->password);

        $user->save();
        return $user;
    }
}
