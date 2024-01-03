<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Response;
use App\Http\Requests\CategoriaRequest;
use App\Http\Requests\AtualizaCategoriaRequest;

class CategoriaController extends Controller
{
    public function cadastrar(CategoriaRequest $request)
    {
        return response()->json(Categoria::create($request->validated()));
    }

    public function listar()
    {
        return response()->json(Categoria::all());
    }

    public function encontrar(int $id)
    {
        return response()->json(Categoria::findOrFail($id));
    }

    public function atualizar(int $id, AtualizaCategoriaRequest $request)
    {
        $dadosValidos = $request->validated();
        $categoria = Categoria::findOrFail($id);
        $categoria->atualiza($dadosValidos);
        $categoria->save();

        return response()->json($categoria);
    } 
    
    public function deletar(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function videoPorCategoria(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        $videosRelacionados = $categoria->videos;

        return response()->json($videosRelacionados);
    }
}
