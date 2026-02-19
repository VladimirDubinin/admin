<?php

namespace Modules\Users\Services;

use Modules\Users\Models\User;

class UserService
{
    public function create(array $fields): User
    {
        return User::query()->create($fields);
    }

    public function update(int $id, array $fields): User
    {
        $user = User::query()->findOrFail($id);
        if (empty($fields['password'])) {
            unset($fields['password']);
        }
        $user->update($fields);
        return $user;
    }
}
