<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Services\CategoriaService;
use App\Http\Requests\CategoriaRequest;
use App\Http\Requests\AtualizaCategoriaRequest;

class CategoriaController extends Controller
{
    private CategoriaService $service;

    public function __construct(CategoriaService $service)
    {
        $this->service = $service;
    }

    public function cadastrar(CategoriaRequest $request)
    {
        $dadosValidados = $request->validated();
        $categoria = $this->service->criaCategoria($dadosValidados);
        $resourceLink = "localhost:8000/api/categoria/{$categoria->id}";

        return response()->json([
            'mensagem' => 'Categoria criada com sucesso: ' . $resourceLink, 
            'data' => $categoria
        ], Response::HTTP_CREATED)->header('Location', $resourceLink);
    }

    public function listar()
    {
        return response()->json($this->service->encontrarTodos());
    }

    public function encontrar(int $id)
    {
        return response()->json($this->service->encontrarPorId($id));
    }

    public function atualizar(int $id, AtualizaCategoriaRequest $request)
    {
        $dadosValidos = $request->validated();
        return response()->json($this->service->atualizaPorId($id, $dadosValidos));
    } 
    
    public function deletar(int $id)
    {
        $this->service->deletaPorId($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function videoPorCategoria(int $id)
    {
        return response()->json($this->service->listarVideosPorIdCategoria($id));
    }
}
