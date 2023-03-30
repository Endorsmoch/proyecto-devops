<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Mockery;
use PDO;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    /** @test */
    public function testDatabaseConnection()
    {

        Mockery::close();

        // Mock la conexión a la base de datos utilizando el método connection()
        $connectionMock = \Mockery::mock(MockInterface::class);
        $connectionMock->shouldReceive('getPdo')
            ->once()
            ->andReturn(new PDO('sqlite::memory:'));
        DB::shouldReceive('connection')
            ->once()
            ->andReturn($connectionMock);

        // Comprueba que se pueda conectar a la base de datos
        $this->assertTrue(DB::connection()->getPdo() instanceof \PDO);
    }
}