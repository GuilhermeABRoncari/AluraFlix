<?php 

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Support\Facades\DB;

class EloquentVideoRepository implements VideoRepository
{
    public function salvar(array $dados): Video
    {
        return Video::create($dados);
    }

    /** @return Video[] */
    public function encontrarTodos()
    {
        return Video::all();
    }

    public function encontrarPorId(int $id): Video
    {
        return Video::findOrFail($id);
    }

    public function atualizar(Video $video, array $dados): Video
    {
        $video->atualiza($dados);
        $video->save();

        return $video;
    }

    public function deletar(Video $video): void
    {
        $video->delete();
    }

    /** @return Video[] */
    public function encontrarPorTitulo(string $pesquisa)
    {
        return Video::where(DB::raw('LOWER(titulo)'), 'like', '%'. strtolower($pesquisa) .'%')->get();
    }
}