<?php

return [
    'header' => [
        'last_modified' => 'Last modified <time datetime=":date">:date</time>',
    ],
    'toc'    => [
        'title'     => 'Table of Content',
        'backToTop' => 'Back to Top',
    ],
    'btn'    => [
        'history' => [
            'content' => 'History',
        ],
        'edit'    => [
            'content' => 'Edit',
        ],
        'link'    => [
            'content' => 'Links',
        ],
        'move'    => [
            'content' => 'Move',
        ],
        'destroy' => [
            'content' => 'Delete',
        ],
    ],
    'modal'  => [
        'history'         => [
            'title' => 'History',
            'lines' => 'Hunk :hunk : Lines :lines',
        ],
        'move'            => [
            'title' => 'Move page',
            'form'  => [
                'field' => [
                    'source'      => [
                        'label' => 'Source URL',
                    ],
                    'destination' => [
                        'label' => 'Destination URL',
                    ],
                ],
            ],
            'btn'   => [
                'save'   => [
                    'content' => 'Move',
                    'loading' => 'Move...',
                ],
                'cancel' => [
                    'content' => 'Cancel',
                ],
            ],
        ],
        'move-success'    => [
            'title'   => 'Move page',
            'content' => 'Page successfully moved from <strong>:source</strong> to <strong>:destination</strong>',
        ],
        'destroy'         => [
            'title'    => 'Delete page',
            'question' => 'Delete page with their content?',
            'note'     => 'This action cannot undone.',
            'btn'      => [
                'yes' => [
                    'content' => 'Yes',
                    'loading' => 'Deleting...',
                ],
                'no'  => [
                    'content' => 'No',
                ],
            ],
        ],
        'destroy-success' => [
            'title'   => 'Delete page',
            'content' => 'Page successfully deleted',
        ],
    ],
];