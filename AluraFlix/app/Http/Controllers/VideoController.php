<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizaVideoRequest;
use App\Models\Video;
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

        return response()->json(
            ['message' => 'Video craido com sucesso: ' . $resourceLink],
             Response::HTTP_CREATED)->header('Location', $resourceLink);
    }

    public function atualizar(Video $video, AtualizaVideoRequest $request)
    {
        $dadosValidados = $request->validated();
        $video->atualiza($dadosValidados);
        $video->save();

        return response()->json($video);
    }

    public function deletaVideo(Video $video)
    {
        $video->delete();
        return response()->json(['message' => "Video deletado com id: {$video->id}"], Response::HTTP_NO_CONTENT);
    }
}
