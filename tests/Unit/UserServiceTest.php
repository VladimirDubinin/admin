<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use modules\Users\Models\User;
use Modules\Users\Services\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testCreateAndUpdateUser(): void
    {
        $fields = [
            'name' => 'Test User',
            'email' => 'test@email.test',
            'password' => 'password',
            'roles' => 1,
        ];
        $userService = new UserService();
        $createdUser = $userService->create($fields);
        $this->assertInstanceOf(User::class, $createdUser);

        $newName = 'New Name';
        $newEmail = 'new@email.test';
        $updatedUser = $userService->update($createdUser->id, [
            'name' => $newName,
            'email' => $newEmail,
        ]);
        $this->assertEquals($newName, $updatedUser->name);
        $this->assertEquals($newEmail, $updatedUser->email);

        $userService->delete($updatedUser->id);
        $deletedUser = User::query()->find($updatedUser->id);
        $this->assertNull($deletedUser);
    }
}
