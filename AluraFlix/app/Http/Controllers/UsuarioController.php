<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RemoverUsuarioRequest;
use App\Http\Requests\RegistroUsuarioRequest;
use App\Models\User;

class UsuarioController extends Controller
{
    private UsuarioService $service;

    public function __construct(UsuarioService $service)
    {
        $this->service = $service;
    }

    public function registrar(RegistroUsuarioRequest $request)
    {
        $dados = $request->obterCredenciais();
        return response()->json($this->service->registrarUsuario($dados), Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $credenciais = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        return response()->json($this->service->autenticar($credenciais));
    }

    public function listarUsuarios()
    {
        return response()->json($this->service->listar());
    }

    public function encontrarPorId(int $id)
    {
        return response()->json($this->service->encontrarPorId($id));
    }

    public function atualizarUsuario(Request $request)
    {
        $usuario = $this->obterUsuarioLogado();

        $dados = $request->validate(['name' => 'string|min:3|max:255']);

        return response()->json($this->service->atualizar($usuario, $dados));
    }

    public function removerUsuario(RemoverUsuarioRequest $request)
    {
        $usuario = $this->obterUsuarioLogado();

        $credenciais = $request->obterCredenciais();
        $this->service->removerUsuario($usuario, $credenciais);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function obterUsuarioLogado(): User
    {
        $usuarioId = Auth::user()->getAuthIdentifier();
        return $this->service->encontrarPorId($usuarioId); 
    }
}
