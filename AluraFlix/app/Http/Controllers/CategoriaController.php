<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;

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
}
