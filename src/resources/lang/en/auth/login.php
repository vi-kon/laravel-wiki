<?php

return [
    'form'  => [
        'field' => [
            'username' => [
                'label' => 'Username',
            ],
            'password' => [
                'label' => 'Password',
            ],
        ],
    ],
    'btn'   => [
        'login' => [
            'content' => 'Login',
        ],
    ],
    'modal' => [
        'login'  => [
            'title' => 'Login',
            'form'  => [
                'alert' => [
                    'success'   => [
                        'content' => 'Successful login',
                    ],
                    'not-match' => [
                        'content' => 'Incorrect username or password',
                    ],
                    'blocked'   => [
                        'content' => 'The username is blocked',
                    ],
                ],
                'field' => [
                    'username' => [
                        'label' => 'Username',
                    ],
                    'password' => [
                        'label' => 'Password',
                    ],
                ],
            ],
            'btn'   => [
                'login'  => [
                    'content' => 'Login',
                    'loading' => 'Login...',
                ],
                'cancel' => [
                    'content' => 'Cancel',
                ],
            ],
        ],
        'logged' => [
            'title'   => 'Belépés',
            'content' => 'Már be vagy jelentkezve <strong>:username</strong> néven.',
        ],
    ],
];