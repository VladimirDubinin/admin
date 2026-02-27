<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\Models\Role;
use modules\Users\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::query()->updateOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Администратор',
                'description' => 'Батя сервера',
            ]
        );

        Role::query()->updateOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'Пользователь',
                'description' => 'Терпила',
            ]
        );

        $user = User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password'  => 'password',
            ]
        );

        $user->addRole($admin);
    }
}
