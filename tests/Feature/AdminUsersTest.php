<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    #[TestWith(['admin.users'], 'usersList')]
    #[TestWith(['admin.users.create'], 'userCreate')]
    #[TestWith(['admin.users.edit', 'GET', ['id' => 1]], 'userEdit')]
    #[TestWith(['admin.users.get_form', 'POST'], 'getUserForm')]
    #[TestWith(['admin.users.store', 'POST'], 'userStore')]
    public function testAccessToPages(string $routeName, string $method = 'GET', array $params = []): void
    {
        if ($method === 'GET') {
            $response = $this->get(route($routeName, $params));
            $response->assertRedirect('/login');
        } elseif ($method === 'POST') {
            $response = $this->post(route($routeName, $params));
            $response->assertRedirect('/login');
        }

        $user = UserFactory::new()->create();
        $this->actingAs($user);

        if ($method === 'GET') {
            $response = $this->get(route($routeName, $params));
            $response->assertRedirect('/');
        } elseif ($method === 'POST') {
            $response = $this->post(route($routeName, $params));
            $response->assertRedirect('/');
        }
    }

    #[TestWith(['admin.users', ['users', 'pageTitle', 'filters']], 'usersListAuthorized')]
    #[TestWith(['admin.users.create', ['pageTitle', 'form_url', 'store_url', 'back_url']], 'userCreateAuthorized')]
    #[TestWith(['admin.users.edit', ['pageTitle', 'form_url', 'store_url', 'back_url', 'delete_url'], ['id' => 1]], 'userEditAuthorized')]
    public function testUserListPage(string $routeName, array $responseParams = [], array $params = []): void
    {
        $user = UserFactory::new()->create();
        $user->addRole('admin');
        $this->actingAs($user);
        $response = $this->get(route($routeName, $params));

        $response->assertStatus(200)
            ->assertViewHasAll($responseParams);
    }

    public function testUserForm(): void
    {
        $user = UserFactory::new()->create();
        $user->addRole('admin');
        $this->actingAs($user);
        $response = $this->post(route('admin.users.get_form'));

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => 0]);
    }

    public function testUserDelete(): void
    {
        $user = UserFactory::new()->create();
        $user->addRole('admin');
        $this->actingAs($user);
        $newUser = UserFactory::new()->create();
        $response = $this->delete(route('admin.users.delete', ['id' => $newUser->id]));

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
