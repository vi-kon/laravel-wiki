<?php

namespace ViKon\Wiki;

use Collective\Html\HtmlServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\ServiceProvider;
use ViKon\Auth\AuthServiceProvider;
use ViKon\Auth\Model\User;
use ViKon\Bootstrap\BootstrapServiceProvider;
use ViKon\DbConfig\DbConfigServiceProvider;
use ViKon\ParserMarkdown\ParserMarkdownServiceProvider;
use ViKon\Support\SupportServiceProvider;
use ViKon\Wiki\Command\InstallCommand;
use ViKon\Wiki\Command\SetupCommand;
use ViKon\Wiki\Parser\WikiParser;

/**
 * Class WikiServiceProvider
 *
 * @package ViKon\Wiki
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class WikiServiceProvider extends AggregateServiceProvider
{
    /**
     * WikiServiceProvider constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $application
     */
    public function __construct(Application $application)
    {
        $this->providers = [
            AuthServiceProvider::class,
            BootstrapServiceProvider::class,
            DbConfigServiceProvider::class,
            ParserMarkdownServiceProvider::class,
            SupportServiceProvider::class,
            HtmlServiceProvider::class,
        ];

        parent::__construct($application);
    }

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

        $this->commands([
                            InstallCommand::class,
                            SetupCommand::class,
                        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton(WikiEngine::class, function (Container $container) {
            return new WikiEngine($container);
        });

        $this->app->singleton(WikiParser::class, function (Container $container) {
            return new WikiParser($container);
        });

        $this->app->singleton('html.wiki', 'ViKon\Wiki\WikiHtmlBuilder');

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'wiki');
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            WikiEngine::class,
            WikiParser::class,
            'html.wiki',
        ];
    }

    /**
     * Set router routes and router options
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $router = $this->app->make(Router::class);

        $router->pattern('url', '.+');

        $router->pattern('pageToken', '\[a-z0-9]+');
        $router->bind('pageToken', function ($token) {
            $repository = $this->app->make(WikiEngine::class)->repository();

            $page = $repository->pageByToken($token);

            // Throw 404 error if page not found by token
            if ($page === null) {
                abort(404);
            }

            return $page;
        });

        $router->pattern('userId', '\d+');
        $router->model('userId', User::class, function () {
            abort(404);
        });

        if (!$this->app->make('app')->routesAreCached()) {
            $attributes = [
                'namespace' => 'ViKon\\Wiki\\Http\\Controller',
            ];
            $router->group($attributes, function () {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }
}