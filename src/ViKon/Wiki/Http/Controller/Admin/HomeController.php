<?php

namespace ViKon\Wiki\Http\Controller\Admin;

use ViKon\Wiki\Http\Controller\BaseController;

/**
 * Class HomeController
 *
 * @package ViKon\Wiki\Http\Controller\Admin
 *
 * @author Kovács Vince<vincekovacs@hotmail.com>
 */
class HomeController extends BaseController
{

    public function index()
    {
        return view(config('wiki.views.admin.home.index'));
    }
}