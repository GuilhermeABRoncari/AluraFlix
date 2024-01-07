<?php 

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentVideoRepository implements VideoRepository
{
    public function salvar(array $dados): Video
    {
        return Video::create($dados);
    }

    /** @return LengthAwarePaginator */
    public function encontrarTodos()
    {
        return Video::paginate(5);
    }

    public function encontrarPorId(int $id): Video
    {
        return Video::findOrFail($id);
    }

    public function atualizar(Video $video, array $dados): Video
    {
        $video->atualiza($dados);
        return $video;
    }

    public function deletar(Video $video): void
    {
        $video->delete();
    }

    /** @return LengthAwarePaginator */
    public function encontrarPorTitulo(string $pesquisa)
    {
        return Video::where(DB::raw('LOWER(titulo)'), 'like', '%'. strtolower($pesquisa) .'%')->paginate(5);
    }

    /** @return Video[] */
    public function obterVideosAleatorios(int $qtd): array
    {
        return Video::inRandomOrder()->limit($qtd)->get()->toArray();
    }
}