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
            return redirect(route('wiki.page.show'));
        },
    ]);

    // --------------------------------------------------------------
    // WIKI
    // --------------------------------------------------------------

    Route::get('wiki/{url?}', [
        'as'   => 'wiki.page.show',
        'uses' => 'PageController@show',
    ]);

    Route::get('wiki-create/{url?}', [
        'permission' => 'wiki.page.create',
        'as'         => 'wiki.page.create',
        'uses'       => 'PageController@create',
    ]);

    Route::get('wiki-edit/{url?}', [
        'permission' => 'wiki.page.edit',
        'as'         => 'wiki.page.edit',
        'uses'       => 'PageController@edit',
    ]);

    Route::get('__ajax/modal/wiki/{pageToken}/history', [
        'as'   => 'ajax.modal.wiki.page.history',
        'uses' => 'PageController@ajaxModalHistory',
    ]);

    Route::get('__ajax/modal/wiki/{pageToken}/link', [
        'as'   => 'ajax.modal.wiki.page.link',
        'uses' => 'PageController@ajaxModalLink',
    ]);

    Route::get('__ajax/modal/wiki/{pageToken}/move', [
        'permission' => 'wiki.page.move',
        'as'         => 'ajax.modal.wiki.page.move',
        'uses'       => 'PageController@ajaxModalMove',
    ]);

    Route::post('__ajax/modal/wiki/{pageToken}/move', [
        'permission' => 'wiki.page.move',
        'uses'       => 'PageController@ajaxMove',
    ]);

    Route::post('__ajax/wiki/{pageToken}/create/store', [
        'permission' => 'wiki.page.create',
        'as'         => 'ajax.wiki.page.create.store',
        'uses'       => 'PageController@ajaxStore',
    ]);

    Route::post('__ajax/wiki/{pageToken}/create/store-draft', [
        'permission' => 'wiki.page.create',
        'as'         => 'ajax.wiki.page.create.store-draft',
        'uses'       => 'PageController@ajaxStoreDraft',
    ]);

    Route::post('__ajax/modal/wiki/{pageToken}/create/preview', [
        'permission' => 'wiki.page.create',
        'as'         => 'ajax.modal.wiki.page.create.preview',
        'uses'       => 'PageController@ajaxModalPreview',
    ]);

    Route::get('__ajax/modal/wiki/{pageToken}/create/cancel', [
        'permission' => 'wiki.page.create',
        'as'         => 'ajax.modal.wiki.page.create.cancel',
        'uses'       => 'PageController@ajaxModalCancel',
    ]);

    Route::post('__ajax/modal/wiki/{pageToken}/create/cancel', [
        'permission' => 'wiki.page.create',
        'uses'       => 'PageController@ajaxCancel',
    ]);

    Route::get('__ajax/modal/wiki/{pageToken}/destroy', [
        'permission' => 'wiki.page.destroy',
        'as'         => 'ajax.modal.wiki.page.destroy',
        'uses'       => 'PageController@ajaxModalDestroy',
    ]);

    Route::post('__ajax/modal/wiki/{pageToken}/destroy', [
        'permission' => 'wiki.page.destroy',
        'uses'       => 'PageController@ajaxDestroy',
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
        'as' => 'ajax.modal.user.settings',
    ]);

    // --------------------------------------------------------------
    // ADMIN
    // --------------------------------------------------------------

    Route::get('admin', [
        'permission' => 'admin.index',
        'as'         => 'admin.index',
        'uses'       => 'Admin\HomeController@index',
    ]);

    // --------------------------------------------------------------
    // ADMIN USER
    // --------------------------------------------------------------

    Route::get('admin/user', [
        'permission' => 'admin.user.index',
        'as'         => 'admin.user.index',
        'uses'       => 'admin\UserController@index',
    ]);

    Route::get('__ajax/table/admin/users', [
        'permission' => 'admin.user.index',
        'as'         => 'ajax.table.admin.user.index.users',
        'uses'       => 'admin\UserController@ajaxIndexTableUsers',
    ]);

    Route::get('__ajax/modal/admin/user/{userId}/show', [
        'permission' => 'admin.user.show',
        'as'         => 'ajax.modal.admin.user.show',
        'uses'       => 'admin\UserController@ajaxShow',
    ]);

    Route::get('__ajax/modal/admin/user/create', [
        'permission' => 'admin.user.create',
        'as'         => 'ajax.modal.admin.user.create',
        'uses'       => 'admin\UserController@ajaxCreate',
    ]);

    Route::post('__ajax/modal/admin/user/create', [
        'permission' => 'admin.user.create',
        'as'         => 'ajax.modal.admin.user.store',
        'uses'       => 'admin\UserController@ajaxStore',
    ]);

    Route::get('__ajax/modal/admin/user/{userId}/edit', [
        'permission' => 'admin.user.edit',
        'as'         => 'ajax.modal.admin.user.edit',
        'uses'       => 'admin\UserController@ajaxEdit',
    ]);

    Route::post('__ajax/modal/admin/user/{userId}/edit', [
        'permission' => 'admin.user.edit',
        'as'         => 'ajax.modal.admin.user.update',
        'uses'       => 'admin\UserController@ajaxUpdate',
    ]);

    Route::get('__ajax/modal/admin/user/{userId}/destroy', [
        'permission' => 'admin.user.destroy',
        'as'         => 'ajax.modal.admin.user.destroy-confirm',
        'uses'       => 'admin\UserController@ajaxDestroyConfirm',
    ]);

    Route::post('__ajax/modal/admin/user/{userId}/destroy', [
        'permission' => 'admin.user.destroy',
        'as'         => 'ajax.modal.admin.user.destroy',
        'uses'       => 'admin\UserController@ajaxDestroy',
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