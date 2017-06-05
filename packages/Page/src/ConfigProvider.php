<?php

namespace Page;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'   => [
                    'page/pagination' => __DIR__ . '/../templates/partial/pagination.php',
                ],
                'paths' => [
                    'page' => [__DIR__ . '/../templates/page'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    Controller\PageController::class => Controller\PageControllerFactory::class,
                    Service\PageService::class       => Service\PageServiceFactory::class,
                    Mapper\PageMapper::class         => Mapper\PageMapperFactory::class,
                    Filter\PageFilter::class         => InvokableFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'admin.pages',
                    'path'            => '/admin/pages',
                    'middleware'      => Controller\PageController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.pages.action',
                    'path'            => '/admin/pages/:action/:id',
                    'middleware'      => Controller\PageController::class,
                    'allowed_methods' => ['GET', 'POST']
                ]
            ],
        ];
    }
}
