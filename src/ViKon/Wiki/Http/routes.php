<?php

//Route::bind('pageByUrl', function ($value) {
//    return \ViKon\Wiki\Models\Page::where('url', $value)
//        ->first();
//});

Route::group([
                 'middleware' => [
                     'auth.login-redirector:admin.auth.login',
                     'auth.has-access',
                 ],
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
    ]);

    Route::get('wiki-create/{url?}', [
        'roles' => 'wiki.create',
        'as'    => 'wiki.create',
        'uses'  => 'PageController@create',
    ]);

    Route::get('wiki-edit/{url?}', [
        'as'    => 'wiki.edit',
        'roles' => 'wiki.edit',
        'uses'  => 'PageController@edit',
    ]);

    Route::get('__ajax/modal/wiki/{pageId}/history', [
        'as'   => 'ajax.modal.wiki.history',
        'uses' => 'PageController@ajaxModalHistory',
    ]);

    Route::get('__ajax/modal/wiki/{pageId}/link', [
        'as'   => 'ajax.modal.wiki.link',
        'uses' => 'PageController@ajaxModalLink',
    ]);

    Route::get('__ajax/modal/wiki/{pageId}/move', [
        'roles' => 'wiki.move',
        'as'    => 'ajax.modal.wiki.move',
        'uses'  => 'PageController@ajaxModalMove',
    ]);

    Route::post('__ajax/modal/wiki/{pageId}/move', [
        'roles' => 'wiki.move',
        'uses'  => 'PageController@ajaxMove',
    ]);

    Route::post('__ajax/wiki/{pageId}/create/store', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.wiki.create.store',
        'uses'  => 'PageController@ajaxStore',
    ]);

    Route::post('__ajax/wiki/{pageId}/create/store-draft', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.wiki.create.store-draft',
        'uses'  => 'PageController@ajaxStoreDraft',
    ]);

    Route::post('__ajax/modal/wiki/{pageId}/create/preview', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.modal.wiki.create.preview',
        'uses'  => 'PageController@ajaxModalPreview',
    ]);

    Route::get('__ajax/modal/wiki/{pageId}/create/cancel', [
        'roles' => 'wiki.create',
        'as'    => 'ajax.modal.wiki.create.cancel',
        'uses'  => 'PageController@ajaxModalCancel',
    ]);

    Route::post('__ajax/modal/wiki/{pageId}/create/cancel', [
        'roles' => 'wiki.create',
        'uses'  => 'PageController@ajaxCancel',
    ]);

    Route::get('__ajax/modal/wiki/{pageId}/destroy', [
        'roles' => 'wiki.destroy',
        'as'    => 'ajax.modal.wiki.destroy',
        'uses'  => 'PageController@ajaxModalDestroy',
    ]);

    Route::post('__ajax/modal/wiki/{pageId}/destroy', [
        'roles' => 'wiki.destroy',
        'uses'  => 'PageController@ajaxDestroy',
    ]);

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

    Route::get('__ajax/modal/admin/user/{userId}/show', [
        'roles' => 'admin.user.show',
        'as'    => 'ajax.modal.admin.user.show',
        'uses'  => 'admin\UserController@ajaxShow',
    ]);

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

    Route::get('__ajax/modal/admin/user/{userId}/edit', [
        'roles' => 'admin.user.edit',
        'as'    => 'ajax.modal.admin.user.edit',
        'uses'  => 'admin\UserController@ajaxEdit',
    ]);

    Route::post('__ajax/modal/admin/user/{userId}/edit', [
        'roles' => 'admin.user.edit',
        'as'    => 'ajax.modal.admin.user.update',
        'uses'  => 'admin\UserController@ajaxUpdate',
    ]);

    Route::get('__ajax/modal/admin/user/{userId}/destroy', [
        'roles' => 'admin.user.destroy',
        'as'    => 'ajax.modal.admin.user.destroy-confirm',
        'uses'  => 'admin\UserController@ajaxDestroyConfirm',
    ]);

    Route::post('__ajax/modal/admin/user/{userId}/destroy', [
        'roles' => 'admin.user.destroy',
        'as'    => 'ajax.modal.admin.user.destroy',
        'uses'  => 'admin\UserController@ajaxDestroy',
    ]);

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