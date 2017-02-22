<?php

return [
    'templates' => [
        'layout' => 'layout/default',
        'map'    => [
            // different layouts
            'layout/default'   => 'templates/layout/default.phtml',
            'layout/admin'     => 'templates/layout/admin.phtml',
            'layout/no'        => 'templates/layout/no.phtml',
            'layout/legacy'    => 'templates/layout/legacy.phtml',

            // map to view files
            'error/error'      => 'templates/error/error.phtml',
            'error/404'        => 'templates/error/404.phtml',

            // pagination
            'admin/pagination' => 'templates/admin/partial/pagination.phtml'
        ],
        'paths'  => [
            'web'    => ['templates/web'],
            'admin'  => ['templates/admin'],
            'layout' => ['templates/layout'],
            'error'  => ['templates/error'],
            'legacy' => ['templates/legacy'],
        ],
    ],

    'view_helpers' => [
        // zend-servicemanager-style configuration for adding view helpers:
        // - 'aliases'
        // - 'invokables'
        // - 'factories'
        // - 'abstract_factories'
        // - etc.
    ],
];