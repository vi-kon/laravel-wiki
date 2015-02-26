<?php

return [
    'views' => [
        'auth' => [
            'login' => 'wiki::auth/login',
            'modal' => [
                'login'         => 'wiki::auth/modal-login',
                'login-success' => 'wiki::auth/modal-login-success',
                'logged'        => 'wiki::auth/modal-logged',
            ],
        ],
        'page' => [
            'show'       => 'wiki::page/show',
            'not-exists' => 'wiki::page/not-exists',
        ],
    ],
];