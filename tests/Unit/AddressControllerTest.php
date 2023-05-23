<?php

namespace Tests\Unit;

use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }

    public function testIndexMethod()
    {
        Address::factory()->create([
            'idUser' => 1,
            'houseNum' => '456',
            'street' => '43-A',
            'city' => 'Merida',
            'state' => 'Yucatan',
            'country' =>'Mexico',
            'postalCode' => '97152'
        ]);

        Address::factory()->create([
            'idUser' => 2,
            'houseNum' => '109',
            'street' => '304',
            'city' => 'Cancun',
            'state' => 'Quintana Roo',
            'country' =>'Mexico',
            'postalCode' => '99201'
        ]);

        $this->get('/api/store/addresses')
        ->assertSee('Merida')
        ->assertSee('Cancun');
    }

    public function testStoreMethod()
    {
        $data = [
            'idUser' => 3,
            'houseNum' => '191',
            'street' => '34-B',
            'city' => 'Ciudad del Carmen',
            'state' => 'Campeche',
            'country' =>'Mexico',
            'postalCode' => '91012'
        ];
        $response = $this->json('POST', 'api/store/addresses', $data);
        $response->assertSee('Address successfully created')->assertSee('Ciudad del Carmen');
    }

    public function testShowMethod()
    {
        Address::factory()->create([
            'idUser' => 1,
            'houseNum' => '456',
            'street' => '43-A',
            'city' => 'Merida',
            'state' => 'Yucatan',
            'country' =>'Mexico',
            'postalCode' => '97152'
        ]);

        Address::factory()->create([
            'idUser' => 2,
            'houseNum' => '109',
            'street' => '304',
            'city' => 'Cancun',
            'state' => 'Quintana Roo',
            'country' =>'Mexico',
            'postalCode' => '99201'
        ]);

        $this->get('/api/store/address/4')
        ->assertSee('Merida');
    }

    public function testUpdateMethod()
    {
        Address::factory()->create([
            'idUser' => 2,
            'houseNum' => '109',
            'street' => '304',
            'city' => 'Cancun',
            'state' => 'Quintana Roo',
            'country' =>'Mexico',
            'postalCode' => '99201'
        ]);

        $data = [
            'city' => 'Monterrey',
            'state' => 'Nuevo Leon'
        ];

        $response = $this->json('PUT', 'api/store/address/6', $data);
        $response->assertSee('Address updated successfully')->assertSee('Monterrey')->assertSee('Nuevo Leon');
    }

    public function testDestroyMethod()
    {
        Address::factory()->create([
            'idUser' => 1,
            'houseNum' => '456',
            'street' => '43-A',
            'city' => 'Merida',
            'state' => 'Yucatan',
            'country' =>'Mexico',
            'postalCode' => '97152'
        ]);

        $this->delete('/api/store/address/7')
        ->assertSee('Record deleted');
    }
    
}