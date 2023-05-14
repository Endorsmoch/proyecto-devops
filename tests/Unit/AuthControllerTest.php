<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testLoginIsCalledOnce()
    {
        $request = new Request();
        $authControllerMock = $this->getMockBuilder(AuthController::class)->onlyMethods(['login'])->getMock();
        $authControllerMock->expects($this->once())->method('login');
        $authControllerMock->getMethodLogin($request);   
    }

    public function testRegisterIsCalledOnce()
    {
        $request = new Request();
        $authControllerMock = $this->getMockBuilder(AuthController::class)->onlyMethods(['register'])->getMock();
        $authControllerMock->expects($this->once())->method('register');
        $authControllerMock->getMethodRegister($request);   
    }

    public function testMeIsCalledOnce()
    {
        $request = new Request();

        $authControllerMock = $this->getMockBuilder(AuthController::class)->onlyMethods(['me'])->getMock();
        $authControllerMock->expects($this->once())->method('me');
        $authControllerMock->getMethodMe($request);  
    }

    public function testLogoutIsCalledOnce()
    {
        $request = new Request();
        $authControllerMock = $this->getMockBuilder(AuthController::class)->onlyMethods(['logout'])->getMock();
        $authControllerMock->expects($this->once())->method('logout');
        $authControllerMock->getMethodLogout($request); 
    }

    public function testRefreshIsCalledOnce()
    {
        $request = new Request();
        $authControllerMock = $this->getMockBuilder(AuthController::class)->onlyMethods(['refresh'])->getMock();
        $authControllerMock->expects($this->once())->method('refresh');
        $authControllerMock->getMethodRefresh($request); 
    }
}