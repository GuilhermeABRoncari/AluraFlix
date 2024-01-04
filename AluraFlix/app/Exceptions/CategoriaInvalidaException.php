<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CategoriaInvalidaException extends Exception
{
    public function render()
    {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => $this->getMessage(),
            'timestamp' => now()->setTimezone('America/Sao_paulo')->format('d-m-Y H:i')
        ], Response::HTTP_BAD_REQUEST);
    }
}
