<?php

return [
    'dependencies' => [
        'invokables' => [
            Web\Action\PingAction::class => Web\Action\PingAction::class,
        ],
        'factories'  => [
            // Web
            Web\Action\HomePageAction::class       => Web\Action\HomePageFactory::class,

            // Admin
            Admin\Action\IndexAction::class        => Admin\Action\IndexFactory::class,
            Admin\Action\LoginAction::class        => Admin\Action\LoginFactory::class,
            Admin\Action\LoginHandleAction::class  => Admin\Action\LoginHandleFactory::class,
            Admin\Action\LogoutHandleAction::class => Admin\Action\LogoutHandleFactory::class
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
        [
            'name'            => 'login',
            'path'            => '/admin/login',
            'middleware'      => Admin\Action\LoginAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'            => 'login-post',
            'path'            => '/admin/login',
            'middleware'      => Admin\Action\LoginHandleAction::class,
            'allowed_methods' => ['POST'],
        ],
        [
            'name'            => 'logout',
            'path'            => '/admin/logout',
            'middleware'      => Admin\Action\LogoutHandleAction::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
