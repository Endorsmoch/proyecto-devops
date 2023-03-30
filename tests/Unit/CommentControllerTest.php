<?php

namespace Tests\Unit;

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function testIndexIsCalledOnce()
    {
        $commentControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['index'])->getMock();
        $commentControllerMock->expects($this->once())->method('index');
        $commentControllerMock->getMethodIndex();   
    }

    public function testStoreIsCalledOnce()
    {
        $request = new Request();
        $commentControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['store'])->getMock();
        $commentControllerMock->expects($this->once())->method('store');
        $commentControllerMock->getMethodStore($request);   
    }

    public function testShowIsCalledOnce()
    {
        $commentControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['show'])->getMock();
        $commentControllerMock->expects($this->once())->method('show');
        $commentControllerMock->getMethodShow("1");   
    }

    public function testUpdateIsCalledOnce()
    {
        $request = new Request();
        $commentControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['update'])->getMock();
        $commentControllerMock->expects($this->once())->method('update');
        $commentControllerMock->getMethodUpdate($request,"1");  
    }

    public function testDestroyIsCalledOnce()
    {
        $commentControllerMock = $this->getMockBuilder(CommentController::class)->onlyMethods(['destroy'])->getMock();
        $commentControllerMock->expects($this->once())->method('destroy');
        $commentControllerMock->getMethodDestroy("1"); 
    }

    
}