<?php 

namespace App\Repositories;

use App\Models\Video;

interface VideoRepository
{
    public function salvar(array $dadosVideo): Video;
    /** @return Video[] */
    public function encontrarTodos();
    public function encontrarPorId(int $id): Video;
    public function atualizar(Video $video, array $dados): Video;
    public function deletar(Video $video): void;
    /** @return Video[] */
    public function encontrarPorTitulo(string $pesquisa);
}