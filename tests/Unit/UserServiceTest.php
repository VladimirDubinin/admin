<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use modules\Users\Models\User;
use Modules\Users\Repositories\UserRepository;
use Modules\Users\Repositories\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testCreateAndUpdateUser(): void
    {
        $name = 'Based Name';
        $fields = [
            'name' => $name,
            'email' => 'test@email.test',
            'password' => 'password',
            'roles' => 1,
        ];
        $userRepository = new UserRepository();
        $createdUser = $userRepository->create($fields);
        $this->assertEquals($name, $createdUser->name);

        $newName = 'New Name';
        $updatedUser = $userRepository->update($createdUser->id, [
            'name' => $newName,
        ]);
        $this->assertEquals($newName, $updatedUser->name);

        $userRepository->delete($updatedUser->id);
        $deletedUser = User::query()->find($updatedUser->id);
        $this->assertNull($deletedUser);
    }
}
