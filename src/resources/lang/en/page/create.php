<?php

return [
    'title' => 'New page',

    'alert' => [
        'saved'     => [
            'content' => 'Page changes saved',
        ],
        'cancelled' => [
            'content' => 'Page editing canceled',
        ],
    ],

    'form'  => [
        'alert' => [
            'saved-draft'        => [
                'content' => 'Page :time saved as draft',
            ],
            'error-saving-draft' => [
                'content' => 'Error during save, successfully saved :time as draft',
            ],
            'draft-exists'       => [
                'content' => 'This page is saved as draft',
            ],
            'not-modified'       => [
                'content' => 'Page not saved, because title or content is not changed',
            ],
        ],
        'field' => [
            'title'   => [
                'label' => 'Title',
            ],
            'content' => [
                'label' => 'Content',
            ],
            'note'    => [
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
        'cancel'  => [
            'title'    => 'Cancel page draft',
            'question' => 'Currently created/edited content lost. Are you sure to cancel this?',
            'note'     => 'This action cannot undone.',
            'btn'      => [
                'yes' => [
                    'content' => 'Yes',
                    'loading' => 'Canceling...',
                ],
                'no'  => [
                    'content' => 'No',
                ],
            ],
        ],
        'preview' => [
            'title' => 'Content preview',
            'btn'   => [
                'save' => [
                    'content' => 'Save',
                    'loading' => 'Saving...',
                ],
                'back' => [
                    'content' => 'Back to edit',
                ],
            ],
        ],
    ],
];