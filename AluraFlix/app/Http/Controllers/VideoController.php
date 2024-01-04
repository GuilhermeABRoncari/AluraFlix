<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\VideoService;
use App\Http\Requests\CriaVideoRequest;
use App\Http\Requests\AtualizaVideoRequest;

class VideoController extends Controller
{
    private VideoService $service;

    public function __construct(VideoService $service)
    {
        $this->service = $service;
    }

    public function retornarTodos()
    {
        return response()->json($this->service->encontrarTodos());
    }

    public function encontrarPorId(Video $video)
    {
        return response()->json($video);
    }

    public function criaNovoVideo(CriaVideoRequest $request)
    {
        $dadosValidos = $request->validated();
        $video = $this->service->criaNovoVideo($dadosValidos);

        $resourceLink = "localhost:8000/api/video/{$video->id}";

        return response()->json([
            'mensagem' => 'Video craido com sucesso: ' . $resourceLink, 
            'data' => $video
        ], Response::HTTP_CREATED)->header('Location', $resourceLink);
    }

    public function atualizar(int $id, AtualizaVideoRequest $request)
    {
        return response()->json($this->service->atualizarPorId($id, $request->validated()));
    }

    public function deletaVideo(Video $video)
    {
        $video->delete();
        return response()->json(['message' => "Video deletado com id: {$video->id}"], Response::HTTP_NO_CONTENT);
    }

    public function encontraVideoPorTitulo(Request $request)
    {
        $pesquisa = strip_tags($request->input('search'));
        return response()->json($this->service->encontrarPorTitulo($pesquisa));
    }
}
