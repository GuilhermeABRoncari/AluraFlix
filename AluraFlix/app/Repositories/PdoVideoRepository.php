<?php 

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Support\Facades\DB;

class PdoVideoRepository implements VideoRepository
{
    public function salvar(array $dadosVideo): Video
    {
        $id = DB::table('videos')->insertGetId([
            'titulo' => $dadosVideo['titulo'],
            'descricao' => $dadosVideo['descricao'],
            'url' => $dadosVideo['url'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $this->encontrarPorId($id);
    }

    public function encontrarTodos()
    {
        return DB::table('videos')->get();
    }

    public function encontrarPorId(int $id): Video
    {
        return DB::table('videos')->find($id);
    }

    public function atualiza(Video $video, array $dadosVideo): Video
    {
        $atualizacoes = [
            'titulo' => isset($dadosVideo['titulo']) ? $dadosVideo['titulo'] : $video->titulo,
            'descricao' => isset($dadosVideo['descricao']) ? $dadosVideo['descricao'] : $video->descricao,
            'url' => isset($dadosVideo['url']) ? $dadosVideo['url'] : $video->url,
            'updated_at' => now(),
        ];
    
        DB::table('videos')->where('id', $video->id)->update($atualizacoes);
    
        return $this->encontrarPorId($video->id);
    }

    public function deleta(Video $video): void
    {
        DB::table('videos')->where('id', $video->id)->delete();
    }
}