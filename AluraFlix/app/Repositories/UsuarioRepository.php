<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UsuarioRepository
{
    public function criarUsuario(array $dados): User;
    /** @return LengthAwarePaginator */
    public function buscarTodosUsuarios();
    public function encontrarPorId(int $id): User;
    public function atualizar(User $usuario, array $dados): User;
    public function deletar(User $usuario): void;
}