<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EloquentUsuarioRepository implements UsuarioRepository
{
    public function criarUsuario(array $dados): User
    {
        return User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'password' => Hash::make($dados['password']),
        ]);
    }

    public function buscarTodosUsuarios()
    {
        return User::paginate(5);
    }

    public function encontrarPorId(int $id): User
    {
        return User::findOrFail($id);
    }

    public function atualizar(User $usuario, array $dados): User
    {
        $usuario->atualiza($dados);
        return $usuario;
    }

    public function deletar(User $usuario): void
    {
        $usuario->delete();
    }
}