<?php

namespace Tests\Feature;

use Database\Seeders\CommentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Comment;
use Mockery;
use Mockery\MockInterface;
use App\Controllers\CommentController;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_dbHasComments(): void
    {
        
        //Se creo un seeder que crea 10 comentarios aleatoriamente
        $this->seed(CommentSeeder::class);

        $this->assertDatabaseCount('comments', 10);

    }

}
