<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase;

    private Categoria $categoria;
    private Video $video;

    public function setUp(): void
    {
        parent::setUp();

        // Configurar dados comuns a vários testes
        $this->categoria = Categoria::factory()->create();
        $this->video = Video::factory()->create(['categoria_id' => $this->categoria->id]);
    }

    public function testCriaNovoVideoComDadosValidos()
    {
        $data = [
            'titulo' => 'Titulo teste',
            'descricao' => 'Descricao Teste',
            'url' => 'https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci',
            'categoria_id' => $this->categoria->id
        ];

        $response = $this->postJson('/api/videos', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveRetornarTodosOsVideos()
    {
        $response = $this->getJson('/api/videos');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveEncontrarPorIdQuandoPassadoUmIdValido()
    {
        $response = $this->getJson("/api/videos/{$this->video->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveReceberNotFoundExceptionAoInformarUmIdInvalido()
    {
        $idInvalido = 99955577788999;
        $response = $this->getJson("/api/videos/{$idInvalido}");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testDeveAtualizarVideoComIdEDadosValidos()
    {
        $data = ['titulo' => 'Novo Titulo'];

        $response = $this->putJson("/api/videos/{$this->video->id}", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveDeletarVideoComIdValido()
    {
        $response = $this->deleteJson("/api/videos/{$this->video->id}");
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
