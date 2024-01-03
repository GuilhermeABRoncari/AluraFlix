<?php 

namespace App\Repositories;

use App\Models\Video;

interface VideoRepository
{
    public function salvar(array $dadosVideo): Video;
    public function encontrarTodos(): array;
    public function encontrarPorId(int $id): Video;
    public function atualizarPorId(int $id, array $dadosVideo): Video;
    public function deletarPorId(int $id): void;
}