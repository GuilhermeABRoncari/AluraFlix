<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;
    private User $usuario;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate', ['--database' => 'sqlite']);
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--database' => 'sqlite']);

        $this->usuario = User::factory()->create([
            'name' => 'Nome Teste',
            'email' => 'teste@email.com',
            'password' => Hash::make('Test123*')
        ]);
    }

    public function testCriaUsuarioComCredenciasValidas()
    {
        $credenciasValidas = [
            'name' => 'Nome Teste',
            'email' => 'criação-teste@email.com',
            'password' => 'Test123*',
            'password_confirmation' => 'Test123*'
        ];

        $this->postJson('/api/registrar', $credenciasValidas)->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveLogarComCredenciaisValidas()
    {
        $credenciais = ['email' => 'teste@email.com', 'password' => 'Test123*'];
        $this->postJson('/api/login', $credenciais)
            ->assertStatus(Response::HTTP_OK);   
    }

    public function testDeveRetornarStatusOkQuantoBuscarTodosUsuarios()
    {
        $this->actingAs($this->usuario)
            ->getJson('/api/usuarios')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testDeveRetornarUsuarioQuandoPassadoIdValido()
    {
        $idValido = $this->usuario->id;
        $this->actingAs($this->usuario)
            ->getJson("/api/usuarios/{$idValido}")
            ->assertStatus(Response::HTTP_OK);
    }

    public function testDeveRetonarStatusOkQuandoAtualizaUsuarioComDadosValidos()
    {
        $dadosValidos = ['name' => 'Novo nome'];
        $this->actingAs($this->usuario)
            ->patchJson("/api/usuarios", $dadosValidos)
            ->assertStatus(Response::HTTP_OK);   
    }

    public function testDeveRetornarStatusNoContentComDelecaoComCredenciaisValidas()
    {
        $credenciaisValidas = [
            'email' => 'teste@email.com', 
            'password' => 'Test123*',
            'password_confirmation' => 'Test123*'
        ];

        $this->actingAs($this->usuario)
            ->deleteJson('/api/usuarios', $credenciaisValidas)
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
