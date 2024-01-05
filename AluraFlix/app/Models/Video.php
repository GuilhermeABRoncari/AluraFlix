<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descricao', 'url', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function atualiza(array $dados): void
    {
        $this->titulo = isset($dados['titulo']) ? $dados['titulo'] : $this->titulo;
        $this->descricao = isset($dados['descricao']) ? $dados['descricao'] : $this->descricao;
        $this->url = isset($dados['url']) ? $dados['url'] : $this->url; 
        $this->categoria_id = isset($dados['categoria_id']) ? $dados['categoria_id'] : $this->categoria_id;
        $this->save();
    }
}
