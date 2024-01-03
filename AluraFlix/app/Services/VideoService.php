<?php 

namespace App\Services;

use App\Models\Video;
use App\Repositories\VideoRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VideoService
{
    private VideoRepository $repository;
    private const NOT_FOUND = "Video não encontrado com id: ";

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
        $video = $this->repository->encontrarPorId($id);
        throw_if(empty($video), new NotFoundHttpException(self::NOT_FOUND . $id));

        return $video;
    }

    public function atualizarPorId(int $id, array $dadosVideo): Video
    {
        $video = $this->repository->encontrarPorId($id);
        throw_if(empty($video), new NotFoundHttpException(self::NOT_FOUND . $id));

        return $this->repository->atualiza($video, $dadosVideo);
    }

    public function deletarPorId(int $id): void
    {
        $video = $this->repository->encontrarPorId($id);
        throw_if(empty($video), new NotFoundHttpException(self::NOT_FOUND . $id));

        $this->repository->deleta($video);
    }
}