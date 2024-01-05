<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriaControllerTest extends TestCase
{
    use RefreshDatabase;
    private Categoria $categoria;
    private User $usuario;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate', ['--database' => 'sqlite']);
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--database' => 'sqlite']);

        $this->categoria = Categoria::factory()->create([
            'titulo' => 'LIVRE',
            'cor' => '00800'
        ]);
        
        $this->usuario = User::factory()->create();
    }
    
    public function testDeveCriarNovaCategoriaERetornarStatusCreated()
    {
        $dados = ['titulo' => 'HUMOR', 'cor' => '0000FF'];
        $this->actingAs($this->usuario)
            ->postJson('/api/categorias', $dados)
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveRetornarStatusOk()
    {
        $this->actingAs($this->usuario)
            ->getJson('/api/categorias')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testDeveEncontrarCategoriaPorIdValido()
    {
        $this->actingAs($this->usuario)
            ->getJson("/api/categorias/{$this->categoria->id}")
            ->assertStatus(Response::HTTP_OK);
    }

    public function testDeveAtualizarCategoriaComDadosValidos()
    {
        $dadosValidos = ['Titulo' => 'TESTE', 'cor' => 'Ffffff'];
        $this->actingAs($this->usuario)
            ->putJson("/api/categorias/{$this->categoria->id}", $dadosValidos)
            ->assertStatus(Response::HTTP_OK);
    }

    public function testDeveRetonarStatusNoContentAoDeletarCategoria()
    {
        $this->actingAs($this->usuario)
            ->deleteJson("/api/categorias/{$this->categoria->id}")
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testDeveRetornarStatusOkAoBuscarVideosPorCategoria()
    {
        $this->actingAs($this->usuario)
            ->getJson("/api/categorias/{$this->categoria->id}/videos")
            ->assertStatus(Response::HTTP_OK);
    }
}
