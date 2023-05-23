<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testRegisterLoginAndLogoutMethod()
    {
        $data = [
            'userName' => 'Endor',
            'email' => 'endor@correo.com',
            'password' => 'elsapo'
        ];

        $response = $this->json('POST', 'api/auth/register', $data);
        $response->assertSee('Successfully created')->assertSee('Endor');

        $data2 = [
            'email' => 'endor@correo.com',
            'password' => 'elsapo'
        ];

        $response = $this->json('POST', 'api/auth/login', $data2);
        $response->assertSee('access_token');

        $this->post('/api/auth/logout')->assertSee('Successfully logged out');

    }
   
}