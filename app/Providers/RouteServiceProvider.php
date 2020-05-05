<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->painelRoute();

        $this->usuarioRoute();

        $this->grupocontasRoute();

        $this->contaRoute();

        $this->movtoRoute();

        $this->acoesRoute();

        $this->tesouroRoute();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function painelRoute()
    {
      Route::prefix('painel')
        ->middleware('web')
        ->namespace('App\Http\Controllers\Painel')
        ->group(base_path('routes/painel.php'));
    }

    protected function usuarioRoute()
    {
      Route::prefix('admin')
        ->middleware('web')
        ->namespace('App\Http\Controllers\Usuario')
        ->group(base_path('routes/usuario.php'));
    }

    protected function grupocontasRoute()
    {
      Route::prefix('admin')
        ->middleware('web')
        ->namespace('App\Http\Controllers\GrupoContas')
        ->group(base_path('routes/grupocontas.php'));
    }

    protected function contaRoute()
    {
      Route::prefix('admin')
        ->middleware('web')
        ->namespace('App\Http\Controllers\Conta')
        ->group(base_path('routes/conta.php'));
    }

    protected function movtoRoute()
    {
      Route::prefix('movto')
        ->middleware('web')
        ->namespace('App\Http\Controllers\Movto')
        ->group(base_path('routes/movto.php'));
    }

    protected function acoesRoute()
    {
      Route::prefix('admin')
        ->middleware('web')
        ->namespace('App\Http\Controllers\Acoes')
        ->group(base_path('routes/acoes.php'));
    }

    protected function tesouroRoute()
    {
      Route::prefix('admin')
        ->middleware('web')
        ->namespace('App\Http\Controllers\Tesouro')
        ->group(base_path('routes/tesouro.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
