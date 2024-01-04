<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Categoria;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriaTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate', ['--database' => 'sqlite']);
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--database' => 'sqlite']);
    }
    public function testCriaNovaCategoriaComDadosValidos()
    {
        $categoria = Categoria::create(['titulo' => 'LIVRE', 'cor' => '008000']);

        static::assertEquals('LIVRE', $categoria->titulo);
        static::assertEquals('008000', $categoria->cor);
    }

    public function testAtualizaCategoriaComDadosValidos()
    {
        $categoria = Categoria::create(['titulo' => 'LIVRE', 'cor' => '008000']);

        $dadosValidos = ['cor' => 'Ffffff'];
        $categoria->atualiza($dadosValidos);
        $categoria->save();

        static::assertEquals('LIVRE', $categoria->titulo);
        static::assertEquals('Ffffff', $categoria->cor);
    }
}
