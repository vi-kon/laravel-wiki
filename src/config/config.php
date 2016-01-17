<?php

return [
    'views' => [
        'auth'  => [
            'login' => 'wiki::auth/login',
            'modal' => [
                'login'         => 'wiki::auth/modal-login',
                'login-success' => 'wiki::auth/modal-login-success',
                'logged'        => 'wiki::auth/modal-logged',
            ],
        ],
        'admin' => [
            'home' => [
                'index' => 'wiki::admin/home/index',
            ],
        ],
        'page'  => [
            'show'       => 'wiki::page/show',
            'not-exists' => 'wiki::page/not-exists',
            'create'     => 'wiki::page/create',
            'edit'       => 'wiki::page/edit',
            'modal'      => [
                'preview'         => 'wiki::page/create-modal-preview',
                'cancel'          => 'wiki::page/create-modal-cancel',
                'history'         => 'wiki::page/show-modal-history',
                'move'            => 'wiki::page/show-modal-move',
                'move-success'    => 'wiki::page/show-modal-move-success',
                'destroy'         => 'wiki::page/show-modal-destroy',
                'destroy-success' => 'wiki::page/show-modal-destroy-success',
            ],
        ],
    ],
];