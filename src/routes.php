<?php

//Route::bind('pageByUrl', function ($value) {
//    return \ViKon\Wiki\Models\Page::where('url', $value)
//        ->first();
//});

Route::group(['namespace' => 'ViKon\Wiki\Http\Controller'], function () {
    Route::get('/', [
        'as'   => 'home',
        'uses' => function () {
            return redirect(route('wiki.show'));
        },
    ]);

    // --------------------------------------------------------------
    // WIKI
    // --------------------------------------------------------------

    Route::get('wiki/{url?}', [
        'as'   => 'wiki.show',
        'uses' => 'PageController@show',
    ])->where('url', '.+');

    Route::get('wiki-edit/{url?}', [
        'as'   => 'wiki.edit',
        'uses' => 'PageController@edit',
    ])->where('url', '.+');

    Route::get('__ajax/modal/wiki/history/{page}', [
        'as'   => 'ajax.modal.wiki.history',
        'uses' => 'PageController@modalHistory',
    ])->where('page', '\d+');

    Route::get('__ajax/modal/wiki/link/{page}', [
        'as'   => 'ajax.modal.wiki.link',
        'uses' => 'PageController@modalLink',
    ])->where('page', '\d+');

    // --------------------------------------------------------------
    // AUTH
    // --------------------------------------------------------------

    Route::get('__ajax/modal/login', [
        'as'   => 'ajax.modal.auth.login',
        'uses' => 'LoginController@login',
    ]);

    Route::post('__ajax/modal/login', [
        'as'   => 'ajax.modal.auth.check',
        'uses' => 'LoginController@check',
    ]);

    Route::get('logout', [
        'as'   => 'auth.logout',
        'uses' => 'LoginController@logout',
    ]);

    Route::get('__ajax/modal/settings', [
        'as'   => 'ajax.modal.user.settings',
        'uses' => '',
    ]);

    // --------------------------------------------------------------
    // ADMIN
    // --------------------------------------------------------------

    Route::get('admin', [
        'roles' => 'admin.index',
        'as'    => 'admin.index',
        'uses'  => 'admin\AdminController@index',
    ]);
});