<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }

    public function testIndexMethod()
    {
        User::factory()->create([
            'userName' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => '1234'
        ]);

        User::factory()->create([
            'userName' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => '5678'
        ]);

        $this->get('/api/account/users')
        ->assertSee('John Doe')
        ->assertSee('Jane Doe');
    }

    public function testShowMethod()
    {
        User::factory()->create([
            'userName' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => '1234'
        ]);

        User::factory()->create([
            'userName' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => '5678'
        ]);

        $this->get('/api/account/users/4')
        ->assertSee('john.doe@example.com');
    }

    public function testUpdateMethod()
    {
        User::factory()->create([
            'userName' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => '1234'
        ]);

        $data = [
            'userName' => 'Endor'
        ];
        $response = $this->json('PUT', 'api/account/users/6', $data);
        $response->assertSee('User updated successfully')->assertSee('Endor');
    }

    public function testDestroyMethod()
    {
        User::factory()->create([
            'userName' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => '5678'
        ]);

        $this->delete('/api/account/users/7')
        ->assertSee('User deleted successfully');
    }

}
