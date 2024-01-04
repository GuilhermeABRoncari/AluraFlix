<?php

namespace Tests\Unit;

use App\Models\Video;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate', ['--database' => 'sqlite']);
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--database' => 'sqlite']);
    }

    public function testCriaNovoVideoComDadosValidos()
    {
        $video = Video::create([
            'titulo' => 'Video teste',
            'descricao' => 'Descrição graciosa',
            'url' => 'https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci',
            'categoria_id' => 1
        ]);

        static::assertEquals('Video teste', $video->titulo);
        static::assertEquals('Descrição graciosa', $video->descricao);
        static::assertEquals('https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci', $video->url);
        static::assertEquals(1, $video->categoria_id);
    }

    public function testAtualizaVideoComDadosValidos()
    {
        $video = Video::create([
            'titulo' => 'Video teste',
            'descricao' => 'Descrição graciosa',
            'url' => 'https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci',
            'categoria_id' => 1
        ]);

        $dadosValidos = [
            'titulo' => 'Titulo Atualizado',
            'descricao' => 'Descrição Atualizada',
            'categoria_id' => 2
        ];

        $video->atualiza($dadosValidos);
        $video->save();

        static::assertEquals('Titulo Atualizado', $video->titulo);
        static::assertEquals('Descrição Atualizada', $video->descricao);
        static::assertEquals('https://www.youtube.com/watch?v=qGvBjgJgn9g&ab_channel=WiLsOnKerci', $video->url);
        static::assertEquals(2, $video->categoria_id);
    }
}
