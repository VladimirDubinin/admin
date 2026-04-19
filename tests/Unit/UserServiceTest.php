<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Users\Domain\Models\User;
use Src\Users\Infrastructure\Repositories\UserRepository;
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
