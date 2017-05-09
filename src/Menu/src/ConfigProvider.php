<?php

namespace Menu;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'   => [
                    'partial/menu-level' => __DIR__ . '/../templates/partial/menu-level.phtml',
                ],
                'paths' => [
                    'menu' => [__DIR__ . '/../templates/menu'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    // services
                    Service\MenuService::class        => Factory\Service\MenuServiceFactory::class,
                    Mapper\MenuMapper::class          => Factory\MapperFactory::class,
                    Filter\MenuFilter::class          => Factory\FilterFactory::class,

                    // controllers
                    Controller\IndexController::class => Factory\Controller\IndexControllerFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'admin.menu',
                    'path'            => '/admin/menu',
                    'middleware'      => Controller\IndexController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.menu.action',
                    'path'            => '/admin/menu/:action/:id',
                    'middleware'      => Controller\IndexController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ],
            ],

            'view_helpers' => [
                'factories' => [
                    'menu'    => View\Helper\MenuItemsFactory::class,
                    'menuUrl' => View\Helper\MenuUrlHelperFactory::class
                ],
            ],
        ];
    }
}
