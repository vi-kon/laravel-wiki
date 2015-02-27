<?php

return [
    'title' => 'New page',

    'form'  => [
        'msg'   => [
            'saved-draft'  => [
                'content' => ':time saved as draft',
            ],
            'draft-exists' => [
                'content' => 'This page is saved as draft',
            ],
        ],
        'field' => [
            'title' => [
                'label' => 'Title',
            ],
            'note'  => [
                'label' => 'Comment',
            ],
        ],
        'btn'   => [
            'save'       => [
                'content' => 'Save',
            ],
            'save-draft' => [
                'content' => 'Save as draft',
            ],
            'preview'    => [
                'content' => 'Preview',
            ],
            'cancel'     => [
                'content' => 'Cancel',
            ],
        ],
    ],
    'modal' => [
        'save'    => [
            'title' => 'Save page',
            'msg'   => [
                'error'        => 'Hiba történt a mentés során.',
                'not-modified' => 'Az oldalon nem történt változás.',
            ],
        ],
        'cancel'  => [
            'title'    => 'Oldal létrehozásának elvetése',
            'question' => 'Az edigg megszerkesztett oldal tartalma elvész. Biztosan elveted az oldal létrehozását?',
            'note'     => 'Ez a művelet nem vonható vissza.',
            'btn'      => [
                'yes' => [
                    'content' => 'Igen',
                    'loading' => 'Elvetés...',
                ],
                'no'  => [
                    'content' => 'Nem',
                ],
            ],
        ],
        'preview' => [
            'title' => 'Előnézet',
            'btn'   => [
                'save' => [
                    'content' => 'Mentés',
                    'loading' => 'Mentés...',
                ],
                'back' => [
                    'content' => 'Vissza a szerkesztéshez',
                ],
            ],
        ],
    ],
];