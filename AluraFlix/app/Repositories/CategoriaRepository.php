<?php 

namespace App\Repositories;

use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;

interface CategoriaRepository
{
    public function salvar(array $dados): Categoria;
    /** @return Categoria[] */
    public function encontrarTodos();
    public function encontrarPorId(int $id): Categoria;
    public function atualizar(Categoria $categoria, array $dados): Categoria;
    public function deletar(Categoria $categoria): void;
    /** @return Video[] */
    public function listarVideos(Categoria $categoria);
    public function categoriaExiste(int $id): bool;
}