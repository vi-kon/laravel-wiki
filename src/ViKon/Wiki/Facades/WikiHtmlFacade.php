<?php

namespace ViKon\Wiki\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class WikiHtmlFacades
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki\Facades
 */
class WikiHtmlFacade extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'html.wiki';
    }
}