<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Video;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase; 

    public function testDeveRetornarTodosOsVideos()
    {
        $response = $this->getJson('/api/videos'); 
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveEncontrarPorIdQuandoPassadoUmIdValido()
    {
        $video = Video::factory()->create();

        $response = $this->getJson("/api/videos/{$video->id}"); 
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveReceberNotFoundExceptionAoInformarUmIdInvalido()
    {
        $idInvalido = 99955577788999;
        $response = $this->getJson("/api/videos/{$idInvalido}"); 
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testCriaNovoVideoComDadosValidos()
    {
        $data = [
            'titulo' => 'Titulo teste',
            'descricao' => 'Descricao Teste',
            'url' => 'https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci'
        ];

        $response = $this->postJson('/api/videos', $data); 
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testDeveAtualizarVideoComIdEDadosValidos()
    {
        $video = Video::factory()->create();
        $data = [
            'Titulo novo de teste'
        ];

        $response = $this->putJson("/api/videos/{$video->id}", $data); 
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeveDeletaVideoComIdValido()
    {
        $video = Video::factory()->create();

        $response = $this->deleteJson("/api/videos/{$video->id}"); 
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
