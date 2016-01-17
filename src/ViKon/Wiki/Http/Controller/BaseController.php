<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class BaseController
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki\Http\Controller
 */
class BaseController extends Controller
{
    use DispatchesCommands, ValidatesRequests;

    public function __construct()
    {
        view()->share('user', \Auth::check()
            ? \Auth::user()
            : null);
    }
}