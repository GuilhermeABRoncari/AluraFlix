<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CriaVideoRequest;

class VideoController extends Controller
{
    public function retornarTodos()
    {
        return response()->json(Video::all());
    }

    public function encontrarPorId(Video $video)
    {
        return response()->json($video);
    }

    public function criaNovoVideo(CriaVideoRequest $request)
    {
        $dadosValidos = $request->validated();
        $video = Video::create($dadosValidos);

        $resourceLink = "localhost:8000/api/video/{$video->id}";

        return response()->json(['message' => 'Video craido com sucesso.'], Response::HTTP_CREATED)->header('Location', $resourceLink);
    }
}
