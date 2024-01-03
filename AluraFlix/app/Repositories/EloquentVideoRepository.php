<?php 

namespace App\Repositories;

use App\Models\Video;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EloquentVideoRepository implements VideoRepository
{
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
        return Video::find($id);
    }

    public function atualiza(Video $video, array $dadosVideo): Video
    {
        $video->atualiza($dadosVideo);
        $video->save();

        return $video;
    }

    public function deleta(Video $video): void
    {
        $video->delete();
    }
}