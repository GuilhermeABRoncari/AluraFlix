<?php 

namespace App\Services;

use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Repositories\CategoriaRepository;
use App\Exceptions\CategoriaInvalidaException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VideoService
{
    private VideoRepository $videoRepository;
    private CategoriaRepository $categoriaRepository;

    public function __construct(VideoRepository $videoRepository, CategoriaRepository $categoriaRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->categoriaRepository = $categoriaRepository;
    }

    public function criaNovoVideo($dados): Video
    {
        $dados['categoria_id'] = isset($dados['categoria_id']) ? $dados['categoria_id'] : 1;

        throw_if (!$this->categoriaRepository->categoriaExiste($dados['categoria_id']), new CategoriaInvalidaException("Categoria com id: {$dados['categoria_id']} não existe."));
            
        return $this->videoRepository->salvar($dados);
    }

    public function encontrarTodos()
    {
        return $this->videoRepository->encontrarTodos();
    }

    public function encontrarPorId(int $id): Video
    {
        return $this->videoRepository->encontrarPorId($id);
    }

    public function atualizarPorId(int $id, array $dadosVideo): Video
    {
        $video = $this->videoRepository->encontrarPorId($id);
        $this->videoRepository->atualizar($video, $dadosVideo);
        return $video;
    }

    public function deletarPorId(int $id): void
    {
        $video = $this->videoRepository->encontrarPorId($id);
        $this->videoRepository->deletar($video);
    }

    /** @return LengthAwarePaginator */
    public function encontrarPorTitulo(string $pesquisa)
    {
        $pesquisaSanitizada = trim($pesquisa);
        return $this->videoRepository->encontrarPorTitulo($pesquisaSanitizada);
    }
}