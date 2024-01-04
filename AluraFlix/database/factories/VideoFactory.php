<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = \App\Models\Video::class;

    public function definition()
    {
        return [
            'id' => 2,
            'titulo' => $this->faker->sentence,
            'descricao' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'categoria_id' => 1
        ];
    }
}
