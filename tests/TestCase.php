<?php

namespace Tests;

use Database\Seeders\UsersSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $seeder = UsersSeeder::class;
}
