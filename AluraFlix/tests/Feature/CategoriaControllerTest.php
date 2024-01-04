<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Categoria;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriaControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testDeveCriarNovaCategoriaERetornarStatusCreated()
    {
        $dados = ['titulo' => 'HUMOR', 'cor' => '0000FF'];
        $response = $this->postJson('/api/categorias', $dados);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveRetornarStatusOk()
    {
        $response = $this->getJson('/api/categorias');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveEncontrarCategoriaPorIdValido()
    {
        $idValido = Categoria::factory()->create();
        $response = $this->getJson("/api/categorias/{$idValido->id}");
        $response->assertStatus(Response::HTTP_OK);
    }
}
