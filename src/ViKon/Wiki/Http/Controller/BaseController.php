<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use ViKon\Auth\Contracts\Keeper;

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
        $keeper      = $this->container->make(Keeper::class);

        $viewFactory->share('user', $keeper->check()
            ? $keeper->user()
            : null);
    }
}