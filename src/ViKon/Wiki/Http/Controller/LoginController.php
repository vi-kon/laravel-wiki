<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use ViKon\Auth\Contracts\Keeper;
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
        $keeper = $this->container->make(Keeper::class);

        if ($keeper->check()) {
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
        $keeper = $this->container->make(Keeper::class);

        if ($keeper->check()) {
            $keeper->logout();
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
        $session = $this->container->make(SessionManager::class)->driver();
        $keeper  = $this->container->make(Keeper::class);

        $keeper->attempt($request->only('username', 'password'), $request->get('remember', false));

        if ($request->ajax() || $request->wantsJson()) {
            $url = $session->pull('url.intended', null);

            return view(config('wiki.views.auth.modal.login-success'))
                ->with('url', $url);
        }

        return redirect()->intended();
    }
}