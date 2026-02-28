<?php

namespace Modules\Users\Services;

use Illuminate\Support\Facades\DB;
use Modules\Users\Models\User;

class UserService
{
    public function create(array $fields): User
    {
        $user = User::query()->create($fields);
        $user->roles()->sync($fields['roles']);
        return $user;
    }

    public function update(int $id, array $fields): User
    {
        $user = User::query()->findOrFail($id);
        if (empty($fields['password'])) {
            unset($fields['password']);
        }
        $user->update($fields);
        $user->roles()->sync($fields['roles']);

        return $user;
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
           $user = User::query()->findOrFail($id);
           $user->roles()->detach();
           $user->delete();
        });
    }
}
