<?php

return [
    'templates' => [
        'layout' => 'layout/default',
        'map'    => [
            'layout/default' => 'templates/layout/default.phtml',
            'error/error'    => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
        ],
        'paths'  => [
            'app'    => ['templates/app'],
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