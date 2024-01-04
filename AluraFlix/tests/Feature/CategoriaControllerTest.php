<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Categoria;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriaControllerTest extends TestCase
{
    use RefreshDatabase;
    private Categoria $categoria;

    public function setUp(): void
    {
        parent::setUp();

        $this->categoria = Categoria::factory()->create([
            'titulo' => 'LIVRE',
            'cor' => '00800'
        ]);
    }
    
    public function testDeveCriarNovaCategoriaERetornarStatusCreated()
    {
        $dados = ['titulo' => 'HUMOR', 'cor' => '0000FF'];
        $this->postJson('/api/categorias', $dados)->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveRetornarStatusOk()
    {
        $this->getJson('/api/categorias')->assertStatus(Response::HTTP_OK);
    }

    public function testDeveEncontrarCategoriaPorIdValido()
    {
        $this->getJson("/api/categorias/{$this->categoria->id}")->assertStatus(Response::HTTP_OK);
    }

    public function testDeveAtualizarCategoriaComDadosValidos()
    {
        $dadosValidos = ['Titulo' => 'TESTE', 'cor' => 'Ffffff'];
        $this->putJson("/api/categorias/{$this->categoria->id}", $dadosValidos)->assertStatus(Response::HTTP_OK);
    }

    public function testDeveRetonarStatusNoContentAoDeletarCategoria()
    {
        $this->deleteJson("/api/categorias/{$this->categoria->id}")->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testDeveRetornarStatusOkAoBuscarVideosPorCategoria()
    {
        $this->getJson("/api/categorias/{$this->categoria->id}/videos")->assertStatus(Response::HTTP_OK);
    }
}
