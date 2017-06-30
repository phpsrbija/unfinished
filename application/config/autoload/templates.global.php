<?php

return [
    'templates' => [
        'layout' => 'layout/default',
        'map'    => [
            'layout/default' => 'templates/layout/default.phtml',
            //'error/error'    => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
        ],
        'paths'  => [
            'layout' => ['templates/layout'],
            'error'  => ['templates/error'],
        ],
    ],
];
