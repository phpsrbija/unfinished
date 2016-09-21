<?php

return [
    'dependencies' => [
        'factories' => [
            // Web
            Web\Action\PingAction::class           => Zend\ServiceManager\Factory\InvokableFactory::class,
            Web\Action\IndexAction::class          => Web\Factory\Action\IndexFactory::class,
            Web\Action\AboutAction::class          => Web\Factory\Action\TemplateFactory::class,
            Web\Action\ContactAction::class        => Web\Factory\Action\TemplateFactory::class,

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
            'middleware'      => Web\Action\IndexAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'       => 'about',
            'path'       => '/about-us',
            'middleware' => Web\Action\AboutAction::class,
        ],
        [
            'name'       => 'contact',
            'path'       => '/contact-us',
            'middleware' => Web\Action\ContactAction::class,
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
