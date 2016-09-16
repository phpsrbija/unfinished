<?php

return [
    'dependencies' => [
        'factories' => [
            // Web
            Web\Action\PingAction::class           => Zend\ServiceManager\Factory\InvokableFactory::class,
            Web\Action\HomePageAction::class       => Web\Factory\Action\HomePageFactory::class,

            // Admin
            Admin\Action\IndexAction::class        => Admin\Factory\Action\IndexFactory::class,
            Admin\Controller\AuthController::class => Admin\Factory\Controller\AuthFactory::class,
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
        [
            'name'            => 'auth',
            'path'            => '/auth/:action',
            'middleware'      => Admin\Controller\AuthController::class,
            'allowed_methods' => ['GET', 'POST'],
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
