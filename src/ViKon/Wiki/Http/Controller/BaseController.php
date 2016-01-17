<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class BaseController
 *
 * @package ViKon\Wiki\Http\Controller
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
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