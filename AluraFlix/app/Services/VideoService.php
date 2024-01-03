<?php 

namespace App\Services;

use App\Models\Video;
use App\Repositories\VideoRepository;

class VideoService
{
    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function encontrarTodos()
    {
        return $this->repository->encontrarTodos();
    }

    public function encontrarPorId(int $id): Video
    {
        return $this->repository->encontrarPorId($id);
    }

    public function atualizarPorId(int $id, array $dadosVideo): Video
    {
        $video = $this->repository->encontrarPorId($id);
        $this->repository->atualiza($video, $dadosVideo);
        return $video;
    }

    public function deletarPorId(int $id): void
    {
        $video = $this->repository->encontrarPorId($id);
        $this->repository->deleta($video);
    }
}