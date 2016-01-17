<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Http\Request;
use ViKon\Auth\Guard;
use ViKon\Wiki\Http\Requests\LoginRequest;

/**
 * Class LoginController
 *
 * @package ViKon\Wiki\Http\Controller
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class LoginController extends BaseController
{
    /**
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {

        if ($this->container->make(Guard::class)->check()) {
            if ($request->ajax()) {
                return view(config('wiki.views.auth.modal.logged'));
            }

            return redirect()->home();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return view(config('wiki.views.auth.modal.login'));
        }

        return view(config('wiki.views.auth.login'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $guard = $this->container->make(Guard::class);

        if ($guard->check()) {
            $guard->logout();
        }

        return redirect()->home();
    }

    /**
     * @param \ViKon\Wiki\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(LoginRequest $request)
    {
        $this->container->make(Guard::class)
                        ->attempt($request->only('username', 'password'), $request->get('remember', false));

        if ($request->ajax() || $request->wantsJson()) {
            $url = session('url.intended', null);

            return view(config('wiki.views.auth.modal.login-success'))
                ->with('url', $url);
        }

        return redirect()->intended();
    }
}