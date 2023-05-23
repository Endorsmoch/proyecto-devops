<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }
    
    public function testIndexMethod()
    {
        Product::factory()->create([
            'name' => 'Xbox One',
            'description' => 'Videogame Console',
            'manufacturer' => 'Microsoft',
            'price' => 11000,
            'stock' => 20 
        ]);

        Product::factory()->create([
            'name' => 'Nintendo Switch',
            'description' => 'Videogame Console',
            'manufacturer' => 'Nintendo',
            'price' => 6500,
            'stock' => 8
        ]);

        $this->get('/api/store/products')
        ->assertSee('Xbox One')
        ->assertSee('Nintendo Switch');
       
    }

    public function testStoreMethod()
    {
        $data = [
            'name' => 'PlayStation 5',
            'description' => 'Videogame Console Next Gen',
            'manufacturer' => 'Sony',
            'price' => 12000,
            'stock' => 10
        ];

        $response = $this->json('POST', 'api/store/products', $data);
        $response->assertSee('PlayStation 5');
    }
    
    public function testShowMethod()
    {
        Product::factory()->create([
            'name' => 'Xbox One',
            'description' => 'Videogame Console',
            'manufacturer' => 'Microsoft',
            'price' => 11000,
            'stock' => 20 
        ]);

        Product::factory()->create([
            'name' => 'Nintendo Switch',
            'description' => 'Videogame Console',
            'manufacturer' => 'Nintendo',
            'price' => 6500,
            'stock' => 8
        ]);

        $this->get('/api/store/products/5')
        ->assertSee('Nintendo Switch');
    }
    
    public function testUpdateMethod()
    {
        Product::factory()->create([
            'name' => 'Samsung S9',
            'description' => 'Celular',
            'manufacturer' => 'Samsung',
            'price' => 17000,
            'stock' => 28 
        ]);

        $data = ['price' => 17500];
        $response = $this->json('PUT', 'api/store/products/6', $data);
        $response->assertSee('Samsung S9')->assertSee(17500);

    }

    public function testDestroyMethod()
    {
        Product::factory()->create([
            'name' => 'Alexa',
            'description' => 'IA for house',
            'manufacturer' => 'Google',
            'price' => 12000,
            'stock' => 100 
        ]);
        $this->delete('/api/store/products/7')
        ->assertSee('Product deleted successfully');
    }

    
}