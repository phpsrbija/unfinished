<?php

namespace Category;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'paths' => [
                    'category' => [__DIR__.'/../templates/category'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    // Service
                    Service\CategoryService::class    => Factory\Service\CategoryServiceFactory::class,
                    Mapper\CategoryMapper::class      => \Std\MapperFactory::class,
                    Filter\CategoryFilter::class      => \Zend\ServiceManager\Factory\InvokableFactory::class,

                    // Controller
                    Controller\IndexController::class => Factory\Controller\IndexFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'admin.categories',
                    'path'            => '/admin/categories',
                    'middleware'      => Controller\IndexController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.categories.action',
                    'path'            => '/admin/categories/{action}/{id}',
                    'middleware'      => Controller\IndexController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ],
            ],

            'view_helpers' => [
                'factories' => [
                    'category' => View\Helper\CategoryHelperFactory::class,
                ],
            ],
        ];
    }
}
