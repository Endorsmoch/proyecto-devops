<?php

namespace Tests\Unit;

use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    public function testIndexIsCalledOnce()
    {
        $addressControllerMock = $this->getMockBuilder(AddressController::class)->onlyMethods(['index'])->getMock();
        $addressControllerMock->expects($this->once())->method('index');
        $addressControllerMock->getMethodIndex();   
    }

    public function testStoreIsCalledOnce()
    {
        $request = new Request();
        $addressControllerMock = $this->getMockBuilder(AddressController::class)->onlyMethods(['store'])->getMock();
        $addressControllerMock->expects($this->once())->method('store');
        $addressControllerMock->getMethodStore($request);   
    }

    public function testShowIsCalledOnce()
    {
        $addressControllerMock = $this->getMockBuilder(AddressController::class)->onlyMethods(['show'])->getMock();
        $addressControllerMock->expects($this->once())->method('show');
        $addressControllerMock->getMethodShow("1");   
    }

    public function testUpdateIsCalledOnce()
    {
        $request = new Request();
        $addressControllerMock = $this->getMockBuilder(AddressController::class)->onlyMethods(['update'])->getMock();
        $addressControllerMock->expects($this->once())->method('update');
        $addressControllerMock->getMethodUpdate($request,"1");  
    }

    public function testDestroyIsCalledOnce()
    {
        $addressControllerMock = $this->getMockBuilder(AddressController::class)->onlyMethods(['destroy'])->getMock();
        $addressControllerMock->expects($this->once())->method('destroy');
        $addressControllerMock->getMethodDestroy("1"); 
    }

    
}