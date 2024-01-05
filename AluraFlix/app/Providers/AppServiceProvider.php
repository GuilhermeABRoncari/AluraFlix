<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use App\Repositories\EloquentCategoriaRepository;
use App\Repositories\EloquentUsuarioRepository;
use App\Repositories\EloquentVideoRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\VideoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VideoRepository::class, EloquentVideoRepository::class);
        $this->app->bind(CategoriaRepository::class, EloquentCategoriaRepository::class);
        $this->app->bind(UsuarioRepository::class, EloquentUsuarioRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
