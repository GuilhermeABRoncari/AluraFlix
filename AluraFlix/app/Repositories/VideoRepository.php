<?php 

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VideoRepository
{
    public function salvar(array $dadosVideo): Video;
    /** @return LengthAwarePaginator */
    public function encontrarTodos();
    public function encontrarPorId(int $id): Video;
    public function atualizar(Video $video, array $dados): Video;
    public function deletar(Video $video): void;
    /** @return LengthAwarePaginator */
    public function encontrarPorTitulo(string $pesquisa);
    /** @return Video[] */
    public function obterVideosAleatorios(int $qtd): array;
}