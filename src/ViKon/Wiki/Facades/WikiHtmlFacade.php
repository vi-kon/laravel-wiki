<?php

namespace ViKon\Wiki\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class WikiHtmlFacade
 *
 * @package ViKon\Wiki\Facades
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class WikiHtmlFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'html.wiki';
    }
}