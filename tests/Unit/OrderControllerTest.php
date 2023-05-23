<?php

namespace Tests\Unit;

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }

    public function testIndexMethod()
    {
        Order::factory()->create([
            'idUser' => 12,
            'idProduct' => 13,
            'amount' => 4,
            'paymentMethod' => 'Credit Card'
        ]);

        Order::factory()->create([
            'idUser' => 14,
            'idProduct' => 15,
            'amount' => 1,
            'paymentMethod' => 'Cash'
        ]);

        $this->get('/api/store/orders')
        ->assertSee(12)
        ->assertSee(14);
    }

    public function testStoreMethod()
    {
        $data = [
            'idUser' => 20,
            'idProduct' => 3,
            'amount' => 2,
            'paymentMethod' => 'Cash'
        ];

        $response = $this->json('POST', 'api/store/orders', $data);
        $response->assertSee('Order successfully created')->assertSee(20)->assertSee(3)->assertSee('Cash');
    }

    public function testShowMethod()
    {
        Order::factory()->create([
            'idUser' => 12,
            'idProduct' => 13,
            'amount' => 4,
            'paymentMethod' => 'Credit Card'
        ]);

        Order::factory()->create([
            'idUser' => 14,
            'idProduct' => 15,
            'amount' => 1,
            'paymentMethod' => 'Cash'
        ]);

        $this->get('/api/store/order/4')
        ->assertSee(12)->assertSee(13)->assertSee('Credit Card');
    }

    public function testUpdateMethod()
    {
        Order::factory()->create([
            'idUser' => 14,
            'idProduct' => 15,
            'amount' => 1,
            'paymentMethod' => 'Cash'
        ]);

        $data = [
            'idUser' => 10,
            'amount' => 3
        ];

        $response = $this->json('PUT', 'api/store/order/6', $data);
        $response->assertSee('Order updated successfully')->assertSee(10)->assertSee(3);
    }

    public function testDestroyMethod()
    {
        Order::factory()->create([
            'idUser' => 1,
            'idProduct' => 233,
            'amount' => 40,
            'paymentMethod' => 'Debit Card'
        ]);

        $this->delete('/api/store/order/7')
        ->assertSee('Record deleted');
    }

    
}