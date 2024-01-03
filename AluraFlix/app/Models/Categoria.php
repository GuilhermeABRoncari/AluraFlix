<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'cor'];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function atualiza(array $dados): void
    {
        $this->titulo = isset($dados['titulo']) ? $dados['titulo'] : $this->titulo;
        $this->cor = isset($dados['cor']) ? $dados['cor'] : $this->cor;
    }
}
