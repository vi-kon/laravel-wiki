<?php

//Route::bind('pageByUrl', function ($value) {
//    return \ViKon\Wiki\Models\Page::where('url', $value)
//        ->first();
//});

Route::model('pageId', 'ViKon\Wiki\Models\Page');

Route::group([
    'namespace'  => 'ViKon\Wiki\Http\Controller',
    'middleware' => 'auth.role',
], function () {
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

    Route::get('wiki-create/{url?}', [
        'roles' => 'wiki.create',
        'as'    => 'wiki.create',
        'uses'  => 'PageController@create',
    ])->where('url', '.+');

    Route::get('wiki-edit/{url?}', [
        'as'    => 'wiki.edit',
        'roles' => 'wiki.edit',
        'uses'  => 'PageController@edit',
    ])->where('url', '.+');

    Route::get('__ajax/modal/wiki/{pageId}/history', [
        'as'   => 'ajax.modal.wiki.history',
        'uses' => 'PageController@modalHistory',
    ])->where('pageId', '\d+');

    Route::get('__ajax/modal/wiki/{pageId}/link', [
        'as'   => 'ajax.modal.wiki.link',
        'uses' => 'PageController@modalLink',
    ])->where('pageId', '\d+');

    Route::post('__ajax/wiki/{pageId}/create/store', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.wiki.create.store',
        'uses'  => 'PageController@ajaxStore',
    ])->where('pageId', '\d+');

    Route::post('__ajax/wiki/{pageId}/create/store-draft', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.wiki.create.store-draft',
        'uses'  => 'PageController@ajaxStoreDraft',
    ])->where('pageId', '\d+');

    Route::post('__ajax/modal/wiki/{pageId}/create/preview', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.modal.wiki.create.preview',
        'uses'  => 'PageController@ajaxModalPreview',
    ])->where('pageId', '\d+');

    Route::post('__ajax/modal/wiki/{pageId}/create/cancel', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.modal.wiki.create.cancel',
        'uses'  => 'PageController@ajaxCancel',
    ])->where('pageId', '\d+');

    // --------------------------------------------------------------
    // AUTH
    // --------------------------------------------------------------

    Route::get('__ajax/modal/login', [
        'as'   => 'ajax.modal.auth.login',
        'uses' => 'LoginController@login',
    ]);

    Route::post('__ajax/modal/login', [
        'uses' => 'LoginController@check',
    ]);

    Route::get('login', [
        'as'   => 'auth.login',
        'uses' => 'LoginController@login',
    ]);

    Route::post('login', [
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