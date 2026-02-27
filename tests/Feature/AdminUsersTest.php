<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Database\Seeders\UsersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Users\Models\User;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    protected string $seeder = UsersSeeder::class;

    #[TestWith(['admin.users'], 'usersList')]
    #[TestWith(['admin.users.create'], 'userCreate')]
    #[TestWith(['admin.users.edit', 'GET', ['id' => 1]], 'userEdit')]
    #[TestWith(['admin.users.get_form', 'POST'], 'getUserForm')]
    #[TestWith(['admin.users.store', 'POST'], 'userStore')]
    #[TestWith(['admin.users.delete', 'POST', ['id' => 1]], 'userDelete')]
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
}
