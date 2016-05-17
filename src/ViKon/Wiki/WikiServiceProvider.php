<?php

namespace ViKon\Wiki;

use Collective\Html\HtmlServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\AggregateServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ViKon\Auth\AuthServiceProvider;
use ViKon\Auth\Model\User;
use ViKon\Bootstrap\BootstrapServiceProvider;
use ViKon\DbConfig\DbConfigServiceProvider;
use ViKon\ParserMarkdown\ParserMarkdownServiceProvider;
use ViKon\Support\SupportServiceProvider;
use ViKon\Wiki\Command\InstallCommand;
use ViKon\Wiki\Command\SetupCommand;
use ViKon\Wiki\Driver;
use ViKon\Wiki\Parser\WikiParser;
use ViKon\Wiki\Policy\PagePolicy;

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
     * @param \Illuminate\Routing\Router             $router
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot(Router $router, Gate $gate)
    {
        $this->loadRoutes($router);
        $this->loadPolicies($gate);

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
            return new WikiParser($container->make(Dispatcher::class));
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
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function loadRoutes(Router $router)
    {
        $router->pattern('url', '.+');

        $router->pattern('pageToken', '\[a-z0-9]+');
        $router->bind('pageToken', function ($token) {
            $repository = $this->app->make(WikiEngine::class)->repository();

            $page = $repository->pageByToken($token);

            // Throw 404 error if page not found by token
            if ($page === null) {
                throw new NotFoundHttpException();
            }

            return $page;
        });

        $router->pattern('userId', '\d+');
        $router->model('userId', User::class, function () {
            throw new NotFoundHttpException();
        });

        if (!$this->app->make('app')->routesAreCached()) {
            $attributes = [
                'namespace'  => 'ViKon\\Wiki\\Http\\Controller',
                'middleware' => 'web',
            ];
            $router->group($attributes, function () {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }

    /**
     * Load authentication policies
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    protected function loadPolicies(Gate $gate)
    {
        $policies = [
            Driver\Eloquent\Page::class => PagePolicy::class,
        ];

        foreach ($policies as $class => $policy) {
            $gate->policy($class, $policy);
        }
    }
}