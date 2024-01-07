<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Support\Facades\Cache;
use App\Repositories\CategoriaRepository;
use App\Exceptions\CategoriaInvalidaException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VideoService
{
    private VideoRepository $videoRepository;
    private CategoriaRepository $categoriaRepository;
    const QTD_VIDEOS_POR_DIA = 5;

    public function __construct(VideoRepository $videoRepository, CategoriaRepository $categoriaRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->categoriaRepository = $categoriaRepository;
    }

    public function criaNovoVideo($dados): Video
    {
        $dados['categoria_id'] = isset($dados['categoria_id']) ? $dados['categoria_id'] : 1;

        $this->verificaIdCategoria($dados);
            
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

    public function atualizarPorId(int $id, array $dados): Video
    {
        $video = $this->videoRepository->encontrarPorId($id);

        $this->verificaIdCategoria($dados);
        
        $this->videoRepository->atualizar($video, $dados);
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

    /** @return Video[] */
    public function videosLiberados(): array
    {
        $dataAtual = Carbon::now()->toDateString();

        $videosDoDia = Cache::remember("videos_do_dia_{$dataAtual}", now()->addDay(), function () {
            return $this->videoRepository->obterVideosAleatorios(self::QTD_VIDEOS_POR_DIA);
        });

        return $videosDoDia;
    }

    private function verificaIdCategoria(array $dados): void
    {
        if (isset($dados['categoria_id'])) {
            throw_if (!$this->categoriaRepository->categoriaExiste($dados['categoria_id']), 
                new CategoriaInvalidaException("Categoria com id: {$dados['categoria_id']} não existe."));
        }
    }
}