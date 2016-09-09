<?php

return [
    'templates' => [
        'layout' => 'layout/default',
        'map'    => [
            'layout/default' => 'templates/layout/default.phtml',
            'layout/admin'   => 'templates/layout/admin.phtml',
            'error/error'    => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
        ],
        'paths'  => [
            'web'    => ['templates/web'],
            'admin'  => ['templates/admin'],
            'layout' => ['templates/layout'],
            'error'  => ['templates/error'],
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