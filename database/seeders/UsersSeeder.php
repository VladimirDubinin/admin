<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use modules\Users\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password'  => \Hash::make('password'),
        ]);
    }
}
