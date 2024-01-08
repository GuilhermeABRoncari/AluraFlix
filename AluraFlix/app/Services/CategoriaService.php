<?php 

namespace App\Services;

use App\Exceptions\CategoriaLivreException;
use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoriaService
{
    private CategoriaRepository $repository;

    public function __construct(CategoriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function criaCategoria(array $dados): Categoria
    {
        return $this->repository->salvar($dados);
    }

    public function encontrarTodos()
    {
        return $this->repository->encontrarTodos();
    }

    public function encontrarPorId(int $id): Categoria
    {
        return $this->repository->encontrarPorId($id);
    }

    public function atualizaPorId(int $id, array $dados): Categoria
    {
        throw_if ($id == 1, new CategoriaLivreException());

        $categoria = $this->repository->encontrarPorId($id);
        return $this->repository->atualizar($categoria, $dados);
    }

    public function deletaPorId(int $id): void
    {
        throw_if ($id == 1, new CategoriaLivreException());

        $categoria = $this->repository->encontrarPorId($id);
        $this->repository->deletar($categoria);
    }

    /** @return LengthAwarePaginator */
    public function listarVideosPorIdCategoria(int $id)
    {
        $categoria = $this->repository->encontrarPorId($id);
        return $this->repository->listarVideos($categoria);
    }
}