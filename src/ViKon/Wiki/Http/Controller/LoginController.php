<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Http\Request;
use ViKon\Wiki\Http\Requests\LoginRequest;

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
        if (\Auth::check()) {
            if (\Request::ajax()) {
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
        if (\Auth::check()) {
            \Auth::logout();
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
        \Auth::attempt($request->only('username', 'password'), $request->get('remember', false));

        if ($request->ajax() || $request->wantsJson()) {
            $url = session('url.intended', null);

            return view(config('wiki.views.auth.modal.login-success'))
                ->with('url', $url);
        }

        return redirect()->intended();
    }
}