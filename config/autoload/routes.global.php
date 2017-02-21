<?php

return [
    'dependencies' => [
        'factories' => [
            // Web
            Web\Action\PingAction::class                 => Zend\ServiceManager\Factory\InvokableFactory::class,
            Web\Action\IndexAction::class                => Web\Factory\Action\IndexFactory::class,
            Web\Action\AboutAction::class                => Web\Factory\Action\TemplateFactory::class,
            Web\Action\ContactAction::class              => Web\Factory\Action\TemplateFactory::class,

            // Legacy
            Web\Legacy\SingleAction::class               => Web\Factory\Legacy\SingleFactory::class,
            Web\Legacy\JoinAction::class                 => Web\Factory\Legacy\JoinFactory::class,
            Web\Legacy\AboutAction::class                => Web\Factory\Legacy\AboutFactory::class,
            Web\Legacy\StatutAction::class               => Web\Factory\Legacy\StatutFactory::class,
            Web\Legacy\ContactAction::class              => Web\Factory\Legacy\ContactFactory::class,
            Web\Legacy\ContactAction::class              => Web\Factory\Legacy\ContactFactory::class,
            Web\Legacy\ListAction::class                 => Web\Factory\Legacy\ListFactory::class,

            // Admin
            Admin\Action\IndexAction::class              => Admin\Factory\Action\IndexFactory::class,
            Admin\Controller\AuthController::class       => Admin\Factory\Controller\AuthFactory::class,
            Admin\Controller\UserController::class       => Admin\Factory\Controller\UserFactory::class,
            Admin\Controller\TagController::class        => Admin\Factory\Controller\TagFactory::class,
            Admin\Controller\PostController::class       => Admin\Factory\Controller\PostFactory::class,
            Admin\Controller\DiscussionController::class => Admin\Factory\Controller\DiscussionFactory::class,
            Admin\Controller\EventController::class      => Admin\Factory\Controller\EventFactory::class,
            Admin\Controller\VideoController::class      => Admin\Factory\Controller\VideoFactory::class,

            // Db
            Zend\Db\Adapter\AdapterInterface::class      => Zend\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],

    'routes' => [
        // Legacy
        [
            'name'       => 'single',
            'path'       => '/single/:slug/',
            'middleware' => Web\Legacy\SingleAction::class,
        ],
        [
            'name'       => 'legacy.join',
            'path'       => '/udruzenje/prikljuci-se/',
            'middleware' => Web\Legacy\JoinAction::class,
        ],
        [
            'name'       => 'legacy.statut',
            'path'       => '/udruzenje/statut/',
            'middleware' => Web\Legacy\StatutAction::class,
        ],
        [
            'name'       => 'legacy.about',
            'path'       => '/zdravo-svete/',
            'middleware' => Web\Legacy\AboutAction::class,
        ],
        [
            'name'       => 'legacy.contact',
            'path'       => '/kontakt/',
            'middleware' => Web\Legacy\ContactAction::class,
        ],
        [
            'name'       => 'legacy.list',
            'path'       => '/clanci/',
            'middleware' => Web\Legacy\ListAction::class,
        ],
        [
            'name'       => 'legacy.list.pagination',
            'path'       => '/clanci/page/:page/',
            'middleware' => Web\Legacy\ListAction::class,
        ],

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
            'name'            => 'admin.posts',
            'path'            => '/admin/posts',
            'middleware'      => Admin\Controller\PostController::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'            => 'admin.posts.action',
            'path'            => '/admin/posts/:action/:id',
            'middleware'      => Admin\Controller\PostController::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name'            => 'admin.posts.doaction',
            'path'            => '/admin/posts/:action',
            'middleware'      => Admin\Controller\PostController::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name'            => 'admin.users',
            'path'            => '/admin/users',
            'middleware'      => Admin\Controller\UserController::class,
            'allowed_methods' => ['GET']
        ],
        [
            'name'            => 'admin.users.action',
            'path'            => '/admin/users/:action/:id',
            'middleware'      => Admin\Controller\UserController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.tags',
            'path'            => '/admin/tags',
            'middleware'      => Admin\Controller\TagController::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'            => 'admin.tags.action',
            'path'            => '/admin/tags/:action/:id',
            'middleware'      => Admin\Controller\TagController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.discussions',
            'path'            => '/admin/discussions',
            'middleware'      => Admin\Controller\DiscussionController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.discussions.action',
            'path'            => '/admin/discussions/:action/:id',
            'middleware'      => Admin\Controller\DiscussionController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.events',
            'path'            => '/admin/events',
            'middleware'      => Admin\Controller\EventController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.events.action',
            'path'            => '/admin/events/:action/:id',
            'middleware'      => Admin\Controller\EventController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.videos',
            'path'            => '/admin/videos',
            'middleware'      => Admin\Controller\VideoController::class,
            'allowed_methods' => ['GET', 'POST']
        ],
        [
            'name'            => 'admin.videos.action',
            'path'            => '/admin/videos/:action/:id',
            'middleware'      => Admin\Controller\VideoController::class,
            'allowed_methods' => ['GET', 'POST']
        ]
    ],
];
