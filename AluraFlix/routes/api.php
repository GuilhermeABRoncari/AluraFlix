<?php

use Illuminate\Http\Request;
use function Laravel\Prompts\search;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registrar', [UsuarioController::class, 'registrar']);
Route::post('/login', [UsuarioController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/videos', [VideoController::class, 'retornarTodos']);
    Route::get('/videos/{video}', [VideoController::class, 'encontrarPorId']);
    Route::post('/videos', [VideoController::class, 'criaNovoVideo']);
    Route::put('/videos/{video}', [VideoController::class, 'atualizar']);
    Route::delete('/videos/{video}', [VideoController::class, 'deletaVideo']);
    Route::get('/videos', [VideoController::class, 'encontraVideoPorTitulo']);

    Route::post('/categorias', [CategoriaController::class, 'cadastrar']);
    Route::get('/categorias', [CategoriaController::class, 'listar']);
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'encontrar']);
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'atualizar']);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'deletar']);
    Route::get('/categorias/{categoria}/videos', [CategoriaController::class, 'videoPorCategoria']);

    Route::get('/usuarios', [UsuarioController::class, 'listarUsuarios']);
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'encontrarPorId']);
    Route::patch('/usuarios', [UsuarioController::class, 'atualizarUsuario']);
    Route::delete('/usuarios', [UsuarioController::class, 'removerUsuario']);
});
