<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testIndexIsCalledOnce()
    {
        $userControllerMock = $this->getMockBuilder(UserController::class)->onlyMethods(['index'])->getMock();
        $userControllerMock->expects($this->once())->method('index');
        $userControllerMock->getMethodIndex();   
    }

    public function testShowIsCalledOnce()
    {
        $userControllerMock = $this->getMockBuilder(UserController::class)->onlyMethods(['show'])->getMock();
        $userControllerMock->expects($this->once())->method('show');
        $userControllerMock->getMethodShow("1");   
    }

    public function testUpdateIsCalledOnce()
    {
        $request = new Request();
        $userControllerMock = $this->getMockBuilder(UserController::class)->onlyMethods(['update'])->getMock();
        $userControllerMock->expects($this->once())->method('update');
        $userControllerMock->getMethodUpdate($request,"1");  
    }

    public function testDestroyIsCalledOnce()
    {
        $userControllerMock = $this->getMockBuilder(UserController::class)->onlyMethods(['destroy'])->getMock();
        $userControllerMock->expects($this->once())->method('destroy');
        $userControllerMock->getMethodDestroy("1"); 
    }

    public function testIndexMethodReturnsAllUsers()
    {
        // Creamos un objeto simulado de la clase User
        $user1 = new User([
            'userName' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
        $user2 = new User([
            'userName' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);
        $users = new Collection([$user1, $user2]);


        // Creamos un objeto simulado de la clase UserController
        $userController = Mockery::mock(UserController::class);

        // Definimos el comportamiento esperado del método index
        $userController->shouldReceive('index')
            ->once()
            ->andReturn($users);

        // Ejecutamos el método index del controlador y comprobamos que devuelve el valor esperado
        $this->assertEquals($users, $userController->index());
    }
}
