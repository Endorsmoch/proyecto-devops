<?php

namespace Tests\Unit;

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function testIndexIsCalledOnce()
    {
        $userControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['index'])->getMock();
        $userControllerMock->expects($this->once())->method('index');
        $userControllerMock->getMethodIndex();   
    }

    public function testStoreIsCalledOnce()
    {
        $request = new Request();
        $userControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['store'])->getMock();
        $userControllerMock->expects($this->once())->method('store');
        $userControllerMock->getMethodStore($request);   
    }

    public function testShowIsCalledOnce()
    {
        $userControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['show'])->getMock();
        $userControllerMock->expects($this->once())->method('show');
        $userControllerMock->getMethodShow("1");   
    }

    public function testUpdateIsCalledOnce()
    {
        $request = new Request();
        $userControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['update'])->getMock();
        $userControllerMock->expects($this->once())->method('update');
        $userControllerMock->getMethodUpdate($request,"1");  
    }

    public function testDestroyIsCalledOnce()
    {
        $userControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['destroy'])->getMock();
        $userControllerMock->expects($this->once())->method('destroy');
        $userControllerMock->getMethodDestroy("1"); 
    }

    
}