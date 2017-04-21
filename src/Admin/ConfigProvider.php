<?php

namespace Admin;

class ConfigProvider
{
    public function __invoke()
    {
        return [

            'templates' => [
                'layout' => 'layout/default',
                'map'    => [
                    // different layouts per package
                    'layout/admin'     => 'templates/layout/admin.phtml',
                    'admin/pagination' => 'templates/admin/partial/pagination.phtml'
                ],
                'paths'  => [
                    'admin' => ['templates/admin'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    Action\IndexAction::class              => Factory\Action\IndexFactory::class,
                    Controller\AuthController::class       => Factory\Controller\AuthFactory::class,
                    Controller\UserController::class       => Factory\Controller\UserFactory::class,
                    Controller\TagController::class        => Factory\Controller\TagFactory::class,
                    Controller\PostController::class       => Factory\Controller\PostFactory::class,
                    Controller\DiscussionController::class => Factory\Controller\DiscussionFactory::class,
                    Controller\EventController::class      => Factory\Controller\EventFactory::class,
                    Controller\VideoController::class      => Factory\Controller\VideoFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'auth',
                    'path'            => '/auth/:action',
                    'middleware'      => Controller\AuthController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ],
                [
                    'name'            => 'admin',
                    'path'            => '/admin',
                    'middleware'      => Action\IndexAction::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.posts',
                    'path'            => '/admin/posts',
                    'middleware'      => Controller\PostController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.posts.action',
                    'path'            => '/admin/posts/:action/:id',
                    'middleware'      => Controller\PostController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ],
                [
                    'name'            => 'admin.posts.doaction',
                    'path'            => '/admin/posts/:action',
                    'middleware'      => Controller\PostController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ],
                [
                    'name'            => 'admin.users',
                    'path'            => '/admin/users',
                    'middleware'      => Controller\UserController::class,
                    'allowed_methods' => ['GET']
                ],
                [
                    'name'            => 'admin.users.action',
                    'path'            => '/admin/users/:action/:id',
                    'middleware'      => Controller\UserController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.tags',
                    'path'            => '/admin/tags',
                    'middleware'      => Controller\TagController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.tags.action',
                    'path'            => '/admin/tags/:action/:id',
                    'middleware'      => Controller\TagController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.discussions',
                    'path'            => '/admin/discussions',
                    'middleware'      => Controller\DiscussionController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.discussions.action',
                    'path'            => '/admin/discussions/:action/:id',
                    'middleware'      => Controller\DiscussionController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.events',
                    'path'            => '/admin/events',
                    'middleware'      => Controller\EventController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.events.action',
                    'path'            => '/admin/events/:action/:id',
                    'middleware'      => Controller\EventController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.videos',
                    'path'            => '/admin/videos',
                    'middleware'      => Controller\VideoController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.videos.action',
                    'path'            => '/admin/videos/:action/:id',
                    'middleware'      => Controller\VideoController::class,
                    'allowed_methods' => ['GET', 'POST']
                ]
            ],
        ];
    }
}
