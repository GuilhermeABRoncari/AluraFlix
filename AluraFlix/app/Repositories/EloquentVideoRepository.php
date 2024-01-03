<?php 

namespace App\Repositories;

use App\Models\Video;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EloquentVideoRepository implements VideoRepository
{
    private const NOT_FOUND = "Video não encontrado com id: ";

    public function salvar(array $dadosVideo): Video
    {
        return Video::create($dadosVideo['titulo'], $dadosVideo['descricao'], $dadosVideo['url']);
    }

    public function encontrarTodos(): array
    {
        return (array) Video::all();
    }

    public function encontrarPorId(int $id): Video
    {
        $video = Video::findOrFail();
        throw_if (empty($video), new NotFoundHttpException(self::NOT_FOUND . $id));

        return $video;
    }

    public function atualizarPorId(int $id, array $dadosVideo): Video
    {
        $video = Video::findOrFail();
        throw_if (empty($video), new NotFoundHttpException(self::NOT_FOUND . $id));

        $video->atualiza($dadosVideo);
        $video->save();

        return $video;
    }

    public function deletarPorId(int $id): void
    {
        $video = Video::findOrFail();
        throw_if (empty($video), new NotFoundHttpException(self::NOT_FOUND . $id));

        $video->delete();
    }
}