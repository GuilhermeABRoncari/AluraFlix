<?php 

namespace App\Repositories;

use App\Models\Video;

class EloquentVideoRepository implements VideoRepository
{
    public function salvar(array $dadosVideo): Video
    {
        return Video::create($dadosVideo);
    }

    public function encontrarTodos()
    {
        return Video::all();
    }

    public function encontrarPorId(int $id): Video
    {
        return Video::findOrFail($id);
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