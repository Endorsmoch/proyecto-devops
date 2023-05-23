<?php

namespace Tests\Unit;

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }
    
    public function testIndexMethod()
    {
        Comment::factory()->create([
            'idProduct' => 233,
            'idUser' => 1,
            'text' => 'Comentario predeterminado 1 :)',
            'likes' => 2
        ]);

        Comment::factory()->create([
            'idProduct' => 43,
            'idUser' => 5,
            'text' => 'Comentario predeterminado 2 :)',
            'likes' => 8
        ]);

        $this->get('/api/store/comments')
        ->assertSee('Comentario predeterminado 1 :)')
        ->assertSee('Comentario predeterminado 2 :)');
    }

    public function testStoreMethod()
    {
        $data = [
            'idProduct' => 32,
            'idUser' => 24,
            'text' => 'Me encanto la mesa!',
            'likes' => 5
        ];

        $response = $this->json('POST', 'api/store/comments', $data);
        $response->assertSee('Comment successfully created')->assertSee(32)->assertSee(24)->assertSee('Me encanto la mesa!');

    } 

    public function testShowMethod()
    {
        Comment::factory()->create([
            'idProduct' => 233,
            'idUser' => 1,
            'text' => 'Comentario predeterminado 1 :)',
            'likes' => 2
        ]);

        Comment::factory()->create([
            'idProduct' => 43,
            'idUser' => 5,
            'text' => 'Comentario predeterminado 2 :)',
            'likes' => 8
        ]);

        $this->get('/api/store/comment/5')
        ->assertSee('Comentario predeterminado 2 :)');
    }

    public function testUpdateMethod()
    {
        Comment::factory()->create([
            'idProduct' => 65,
            'idUser' => 18,
            'text' => 'Asombroso :)',
            'likes' => 20
        ]);

        $data = [
            'text' => 'El producto es asombroso!',
            'likes' => 21
        ];
        
        $response = $this->json('PUT', 'api/store/comment/6', $data);
        $response->assertSee('Comment updated successfully')->assertSee('El producto es asombroso!')->assertSee(21);
    }

    public function testDestroyMethod()
    {
        Comment::factory()->create([
            'idProduct' => 90,
            'idUser' => 19,
            'text' => 'Está horrible el producto.',
            'likes' => 12
        ]);
        $this->delete('/api/store/comment/7')
        ->assertSee('Record deleted');
    }
}