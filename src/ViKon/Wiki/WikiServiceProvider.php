<?php

namespace ViKon\Wiki;

use Illuminate\Support\ServiceProvider;

class WikiServiceProvider extends ServiceProvider {

    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'wiki');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'wiki');

        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('wiki.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        include __DIR__ . '/../../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
    }
}