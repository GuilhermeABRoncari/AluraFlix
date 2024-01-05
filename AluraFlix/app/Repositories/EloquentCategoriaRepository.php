<?php 

namespace App\Repositories;

use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentCategoriaRepository implements CategoriaRepository
{
    public function salvar(array $dados): Categoria
    {
        return Categoria::create($dados);
    }

    /** @return LengthAwarePaginator */
    public function encontrarTodos()
    {
        return Categoria::paginate(5);
    }

    public function encontrarPorId(int $id): Categoria
    {
        return Categoria::findOrFail($id);
    }

    public function atualizar(Categoria $categoria, array $dados): Categoria
    {
        $categoria->atualiza($dados);
        return $categoria;
    }

    public function deletar(Categoria $categoria): void
    {
        $categoria->delete();
    }

    /** @return LengthAwarePaginator */
    public function listarVideos(Categoria $categoria)
    {
        return $categoria->videos()->paginate(5);
    }

    public function categoriaExiste(int $id): bool
    {
        return Categoria::where('id', $id)->exists();
    }
}