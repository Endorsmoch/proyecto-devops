<?php

namespace Tests\Unit;

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

    
}