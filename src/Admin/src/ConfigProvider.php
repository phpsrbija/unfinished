<?php

namespace Admin;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'   => [
                    'layout/admin'     => __DIR__ . '/../templates/layout/admin.phtml',
                    'admin/pagination' => __DIR__ . '/../templates/admin/partial/pagination.phtml',
                ],
                'paths' => [
                    'admin' => [__DIR__ . '/../templates/admin'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    Action\IndexAction::class        => Factory\Action\IndexFactory::class,
                    Controller\AuthController::class => Factory\Controller\AuthFactory::class,
                    Controller\UserController::class => Factory\Controller\UserFactory::class,
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
            ],

            'view_helpers' => [
                'factories' => [
                    'admin' => Factory\View\Helper\AdminUserHelperFactory::class,
                ],
            ],

        ];
    }
}
