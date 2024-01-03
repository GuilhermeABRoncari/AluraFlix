<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descricao', 'url'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function atualiza(array $dados): void
    {
        $this->titulo = isset($dados['titulo']) ? $dados['titulo'] : $this->titulo;
        $this->descricao = isset($dados['descricao']) ? $dados['descricao'] : $this->descricao;
        $this->url = isset($dados['url']) ? $dados['url'] : $this->url; 
    }
}
