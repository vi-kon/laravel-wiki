<?php

namespace ViKon\Wiki\Http\Controller\Admin;

use ViKon\Wiki\Http\Controller\BaseController;

class HomeController extends BaseController {

    public function index() {
        return view(config('wiki.views.admin.home.index'));
    }
}