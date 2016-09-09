<?php

return [
    'dependencies' => [
        'invokables' => [
            Web\Action\PingAction::class => Web\Action\PingAction::class,
        ],
        'factories'  => [
            // Web
            Web\Action\HomePageAction::class => Web\Action\HomePageFactory::class,

            // Admin
            Admin\Action\IndexAction::class  => Admin\Action\IndexFactory::class,
        ],
    ],

    'routes' => [
        // Web
        [
            'name'            => 'home',
            'path'            => '/',
            'middleware'      => Web\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'            => 'api.ping',
            'path'            => '/api/ping',
            'middleware'      => Web\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],

        // Admin
        [
            'name'            => 'admin',
            'path'            => '/admin',
            'middleware'      => Admin\Action\IndexAction::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
