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
        'uses' => 'PageController@ajaxModalHistory',
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

    Route::get('__ajax/modal/wiki/{pageId}/create/cancel', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.modal.wiki.create.cancel',
        'uses'  => 'PageController@ajaxModalCancel',
    ])->where('pageId', '\d+');

    Route::post('__ajax/modal/wiki/{pageId}/create/cancel', [
        'roles' => 'wiki.create',
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
        'uses'  => 'Admin\HomeController@index',
    ]);

    // --------------------------------------------------------------
    // ADMIN USER
    // --------------------------------------------------------------

    Route::get('admin/user', [
        'roles' => 'admin.user.index',
        'as'    => 'admin.user.index',
        'uses'  => 'admin\UserController@index',
    ]);

    Route::get('__ajax/table/admin/users', [
        'roles' => 'admin.user.index',
        'as'    => 'ajax.table.admin.user.index.users',
        'uses'  => 'admin\UserController@ajaxIndexTableUsers',
    ]);

    Route::get('__ajax/modal/admin/user/{user}/show', [
        'roles' => 'admin.user.show',
        'as'    => 'ajax.modal.admin.user.show',
        'uses'  => 'admin\UserController@ajaxShow',
    ])
        ->where('user', '\d+');

    Route::get('__ajax/modal/admin/user/create', [
        'roles' => 'admin.user.create',
        'as'    => 'ajax.modal.admin.user.create',
        'uses'  => 'admin\UserController@ajaxCreate',
    ]);

    Route::post('__ajax/modal/admin/user/create', [
        'roles' => 'admin.user.create',
        'as'    => 'ajax.modal.admin.user.store',
        'uses'  => 'admin\UserController@ajaxStore',
    ]);

    Route::get('__ajax/modal/admin/user/{user}/edit', [
        'roles' => 'admin.user.edit',
        'as'    => 'ajax.modal.admin.user.edit',
        'uses'  => 'admin\UserController@ajaxEdit',
    ])->where('user', '\d+');

    Route::post('__ajax/modal/admin/user/{user}/edit', [
        'roles' => 'admin.user.edit',
        'as'    => 'ajax.modal.admin.user.update',
        'uses'  => 'admin\UserController@ajaxUpdate',
    ])->where('user', '\d+');

    Route::get('__ajax/modal/admin/user/{user}/destroy', [
        'roles' => 'admin.user.destroy',
        'as'    => 'ajax.modal.admin.user.destroy-confirm',
        'uses'  => 'admin\UserController@ajaxDestroyConfirm',
    ])->where('user', '\d+');

    Route::post('__ajax/modal/admin/user/{user}/destroy', [
        'roles' => 'admin.user.destroy',
        'as'    => 'ajax.modal.admin.user.destroy',
        'uses'  => 'admin\UserController@ajaxDestroy',
    ])->where('user', '\d+');

    // --------------------------------------------------------------
    // ADMIN ROLE
    // --------------------------------------------------------------

    Route::get('admin/roles', [
        'as'   => 'ajax.admin.roles.index',
        'uses' => 'admin\RoleController@index',
    ]);

    Route::get('__ajax/admin/roles/table/roles', [
        'as'   => 'ajax.admin.roles.index.table.roles',
        'uses' => 'admin\RoleController@ajaxIndexTableRoles',
    ]);

    // --------------------------------------------------------------
    // ADMIN ACCESS CONTROL
    // --------------------------------------------------------------

    Route::get('admin/access-control', [
        'as'   => 'admin.access-control.index',
        'uses' => 'admin\AccessControlController@index',
    ]);

    // --------------------------------------------------------------
    // ADMIN EXTENSION MANAGER
    // --------------------------------------------------------------

    Route::get('admin/extension-manager', [
        'as'   => 'admin.extension-manager.index',
        'uses' => 'admin\ExtensionManagerController@index',
    ]);

    // --------------------------------------------------------------
    // ADMIN EXTENSION MANAGER
    // --------------------------------------------------------------

    Route::get('admin/settings', [
        'as'   => 'admin.settings.index',
        'uses' => 'admin\SettingsController@index',
    ]);
});