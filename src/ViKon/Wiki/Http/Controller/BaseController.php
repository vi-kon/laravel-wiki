<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use ViKon\Auth\Guard;

/**
 * Class BaseController
 *
 * @package ViKon\Wiki\Http\Controller
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class BaseController extends Controller
{
    use ValidatesRequests;

    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /**
     * BaseController constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $viewFactory = $this->container->make(Factory::class);
        $guard       = $this->container->make(Guard::class);

        $viewFactory->share('user', $guard->check()
            ? $guard->user()
            : null);
    }
}