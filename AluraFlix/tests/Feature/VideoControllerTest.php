<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase;

    private Categoria $categoria;
    private Video $video;

    public function setUp(): void
    {
        parent::setUp();

        $this->categoria = Categoria::factory()->create([
            'titulo' => 'LIVRE',
            'cor' => '008000'
        ]);

        $this->video = Video::factory([
            'titulo' => 'Video de Teste',
            'descricao' => 'Descrição graciosa',
            'url' => 'https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci'
        ])->create(['categoria_id' => $this->categoria->id]);
    }

    public function testCriaNovoVideoComDadosValidos()
    {
        $data = [
            'titulo' => 'Titulo teste',
            'descricao' => 'Descricao Teste',
            'url' => 'https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci',
            'categoria_id' => $this->categoria->id
        ];

        $this->postJson('/api/videos', $data)->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveRetornarTodosOsVideos()
    {
        $this->getJson('/api/videos')->assertStatus(Response::HTTP_OK);
    }

    public function testDeveEncontrarPorIdQuandoPassadoUmIdValido()
    {
        $this->getJson("/api/videos/{$this->video->id}")->assertStatus(Response::HTTP_OK);
    }

    public function testDeveReceberNotFoundExceptionAoInformarUmIdInvalido()
    {
        $idInvalido = 99955577788999;
        $this->getJson("/api/videos/{$idInvalido}")->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testDeveAtualizarVideoComIdEDadosValidos()
    {
        $data = ['titulo' => 'Novo Titulo'];
        $this->putJson("/api/videos/{$this->video->id}", $data)->assertStatus(Response::HTTP_OK);
    }

    public function testDeveDeletarVideoComIdValido()
    {
        $this->deleteJson("/api/videos/{$this->video->id}")->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
