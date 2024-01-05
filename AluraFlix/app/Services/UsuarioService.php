<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UsuarioRepository;
use Illuminate\Validation\ValidationException;

class UsuarioService
{
    private UsuarioRepository $repository;

    public function __construct(UsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registrarUsuario(array $dados): string
    {
        $usuario = $this->repository->criarUsuario($dados);

        Auth::attempt(['email'=> $usuario->email,'password'=> $dados['password']]);

        if (!Auth::check()) {
            throw ValidationException::withMessages([
                'mensagem' => ['Falha ao fazer login.'],
            ]);
        }

        return $this->gerarToken($usuario);
    }

    public function autenticar(array $credenciais): string
    {
        if (Auth::attempt(['email' => $credenciais['email'], 'password' => $credenciais['password']])) {
            $usuario = Auth::user();
            return $this->gerarToken($usuario);
        } else throw ValidationException::withMessages(['mensagem' => 'Email ou senha invalidos']);
    }

    public function listar()
    {
        return $this->repository->buscarTodosUsuarios();
    }

    public function encontrarPorId(int $id): User
    {
        return $this->repository->encontrarPorId($id);
    }

    public function atualizar(User $usuario, array $dados): User
    {
        return $this->repository->atualizar($usuario, $dados);
    }

    public function removerUsuario(User $usuario, array $credenciais): void
    {
        if (!Hash::check($credenciais['password'], $usuario->password)) {
            throw ValidationException::withMessages(['erro' => 'Email ou senha invalidos.']);
        }
        
        $this->repository->deletar($usuario);
    }

    private function gerarToken($usuario): string
    {
        $usuario->tokens()->delete();
        return $usuario->createToken('token')->plainTextToken;
    }
}