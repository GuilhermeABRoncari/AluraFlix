<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

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
}
