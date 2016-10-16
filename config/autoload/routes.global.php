<?php

return [
    'dependencies' => [
        'factories' => [
            // Web
            Web\Action\PingAction::class            => Zend\ServiceManager\Factory\InvokableFactory::class,
            Web\Action\IndexAction::class           => Web\Factory\Action\IndexFactory::class,
            Web\Action\AboutAction::class           => Web\Factory\Action\TemplateFactory::class,
            Web\Action\ContactAction::class         => Web\Factory\Action\TemplateFactory::class,

            // Admin
            Admin\Action\IndexAction::class         => Admin\Factory\Action\IndexFactory::class,
            Admin\Controller\AuthController::class  => Admin\Factory\Controller\AuthFactory::class,
            Admin\Action\ArticlePageAction::class   => Admin\Factory\Action\ArticlePageFactory::class,
            Admin\Model\Repository\ArticleRepositoryInterface::class => Admin\Factory\Model\Repository\ArticleRepositoryFactory::class,
            Admin\Model\Storage\ArticleStorageInterface::class => Admin\Factory\Db\ArticleTableGatewayFactory::class,

            // Db
            Zend\Db\Adapter\AdapterInterface::class => Zend\Db\Adapter\AdapterServiceFactory::class,
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
        [
            'name'            => 'article',
            'path'            => '/admin/article/:action',
            'middleware'      => Admin\Action\ArticlePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ]
    ],
];
