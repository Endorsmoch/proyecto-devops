<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testIndexIsCalledOnce()
    {
        $productControllerMock = $this->getMockBuilder(ProductController::class)->onlyMethods(['index'])->getMock();
        $productControllerMock->expects($this->once())->method('index');
        $productControllerMock->getMethodIndex();   
    }

    public function testStoreIsCalledOnce()
    {
        $request = new Request();
        $productControllerMock = $this->getMockBuilder(ProductController::class)->onlyMethods(['store'])->getMock();
        $productControllerMock->expects($this->once())->method('store');
        $productControllerMock->getMethodStore($request);   
    }

    public function testShowIsCalledOnce()
    {
        $productControllerMock = $this->getMockBuilder(ProductController::class)->onlyMethods(['show'])->getMock();
        $productControllerMock->expects($this->once())->method('show');
        $productControllerMock->getMethodShow("1");   
    }

    public function testUpdateIsCalledOnce()
    {
        $request = new Request();
        $productControllerMock = $this->getMockBuilder(ProductController::class)->onlyMethods(['update'])->getMock();
        $productControllerMock->expects($this->once())->method('update');
        $productControllerMock->getMethodUpdate($request,"1");  
    }

    public function testDestroyIsCalledOnce()
    {
        $productControllerMock = $this->getMockBuilder(ProductController::class)->onlyMethods(['destroy'])->getMock();
        $productControllerMock->expects($this->once())->method('destroy');
        $productControllerMock->getMethodDestroy("1"); 
    }

    
}