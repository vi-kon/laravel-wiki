<?php

namespace ViKon\Wiki;

use Illuminate\Contracts\Container\Container;
use ViKon\Wiki\Driver\Eloquent\Repository;

/**
 * Class WikiEngine
 *
 * @package ViKon\Wiki
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 */
class WikiEngine
{
    /** @type \ViKon\Wiki\Driver\Eloquent\Repository */
    protected $repository;

    /**
     * WikiEngine constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->repository = new Repository($container);
    }

    /**
     * @return \ViKon\Wiki\Contract\Repository
     */
    public function repository()
    {
        return $this->repository;
    }
}