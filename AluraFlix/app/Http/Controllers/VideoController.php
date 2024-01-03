<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Response;
use App\Services\VideoService;
use App\Repositories\VideoRepository;
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
