<?php 

namespace App\Repositories;

use App\Models\Video;

interface VideoRepository
{
    public function salvar(array $dadosVideo): Video;
    public function encontrarTodos(): array;
    public function encontrarPorId(int $id): Video;
    public function atualiza(Video $video, array $dadosVideo): Video;
    public function deleta(Video $video): void;
}