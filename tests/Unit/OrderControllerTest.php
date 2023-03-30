<?php

namespace Tests\Unit;

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function testIndexIsCalledOnce()
    {
        $orderControllerMock = $this->getMockBuilder(OrderController::class)->onlyMethods(['index'])->getMock();
        $orderControllerMock->expects($this->once())->method('index');
        $orderControllerMock->getMethodIndex();   
    }

    public function testStoreIsCalledOnce()
    {
        $request = new Request();
        $orderControllerMock = $this->getMockBuilder(OrderController::class)->onlyMethods(['store'])->getMock();
        $orderControllerMock->expects($this->once())->method('store');
        $orderControllerMock->getMethodStore($request);   
    }

    public function testShowIsCalledOnce()
    {
        $orderControllerMock = $this->getMockBuilder(OrderController::class)->onlyMethods(['show'])->getMock();
        $orderControllerMock->expects($this->once())->method('show');
        $orderControllerMock->getMethodShow("1");   
    }

    public function testUpdateIsCalledOnce()
    {
        $request = new Request();
        $orderControllerMock = $this->getMockBuilder(OrderController::class)->onlyMethods(['update'])->getMock();
        $orderControllerMock->expects($this->once())->method('update');
        $orderControllerMock->getMethodUpdate($request,"1");  
    }

    public function testDestroyIsCalledOnce()
    {
        $orderControllerMock = $this->getMockBuilder(OrderController::class)->onlyMethods(['destroy'])->getMock();
        $orderControllerMock->expects($this->once())->method('destroy');
        $orderControllerMock->getMethodDestroy("1"); 
    }

    
}