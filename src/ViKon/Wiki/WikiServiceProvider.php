<?php

namespace ViKon\Wiki;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use ViKon\Auth\Model\User;
use ViKon\Wiki\Models\Page;

/**
 * Class WikiServiceProvider
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki\Facades
 */
class WikiServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'wiki');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'wiki');

        $this->publishes([
                             __DIR__ . '/../../config/config.php' => config_path('wiki.php'),
                         ], 'config');

        $this->publishes([
                             __DIR__ . '/../../database/migrations/' => base_path('/database/migrations'),
                         ], 'migrations');

        $this->publishes([
                             __DIR__ . '/../../database/seeds/' => base_path('/database/seeds'),
                         ], 'seeds');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('html.wiki', 'ViKon\Wiki\WikiHtmlBuilder');

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'wiki');
    }

    /**
     * Set router routes and router options
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $router = $this->app->make(Router::class);

        if (!$this->app->make('app')->routesAreCached()) {
            $attributes = [
                'namespace' => 'ViKon\\Wiki\\Http\\Controller',
            ];
            $router->group($attributes, function () {
                require __DIR__ . '/Http/routes.php';
            });
        }

        $router->pattern('url', '.+');

        $router->pattern('pageId', '\d+');
        $router->model('pageId', Page::class, function () {
            abort(404);
        });

        $router->pattern('userId', '\d+');
        $router->model('userId', User::class, function () {
            abort(404);
        });
    }
}