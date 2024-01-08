<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CategoriaLivreException extends Exception
{
    public function render()
    {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Categoria LIVRE de id = 1 não pode ser deletada ou modificada.',
            'timestamp' => now()->setTimezone('America/Sao_paulo')->format('d-m-Y H:i')
        ], Response::HTTP_BAD_REQUEST);
    }
}
