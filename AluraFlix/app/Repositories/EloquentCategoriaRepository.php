<?php 

namespace App\Repositories;

use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;

class EloquentCategoriaRepository implements CategoriaRepository
{
    public function salvar(array $dados): Categoria
    {
        return Categoria::create($dados);
    }

    /** @return Categoria[] */
    public function encontrarTodos()
    {
        return Categoria::all();
    }

    public function encontrarPorId(int $id): Categoria
    {
        return Categoria::find($id);
    }

    public function atualizar(Categoria $categoria, array $dados): Categoria
    {
        $categoria->atualiza($dados);
        $categoria->save();

        return $categoria;
    }

    public function deletar(Categoria $categoria): void
    {
        $categoria->delete();
    }

    /** @return Video[] */
    public function listarVideos(Categoria $categoria)
    {
        return $categoria->videos;
    }

    public function categoriaExiste(int $id): bool
    {
        return Categoria::where('id', $id)->exists();
    }
}