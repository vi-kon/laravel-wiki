<?php

namespace ViKon\Wiki;

use Illuminate\Support\ServiceProvider;

/**
 * Class WikiServiceProvider
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki\Facades
 */
class WikiServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'wiki');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'wiki');

        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('wiki.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../database/seeds/' => base_path('/database/seeds'),
        ], 'seeds');

        include __DIR__ . '/../../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('html.wiki', 'ViKon\Wiki\WikiHtmlBuilder');

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'wiki');
    }
}