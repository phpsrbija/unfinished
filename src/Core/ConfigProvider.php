<?php

namespace Core;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    'session'                       => Factory\SessionFactory::class,

                    // Services
                    Service\AdminUserService::class => Factory\Service\AdminUserServiceFactory::class,
                    Service\MeetupApiService::class => Factory\Service\MeetupApiServiceFactory::class,

                    // Mappers
                    Mapper\AdminUsersMapper::class  => Factory\MapperFactory::class,

                    // Filters
                    Filter\AdminUserFilter::class   => Factory\FilterFactory::class,

                    // Register custom Middlewares
                    Middleware\AdminAuth::class     => Factory\Middleware\AdminAuthFactory::class,
                ],
            ],

            'middleware_pipeline' => [
                // execute this middlweare on every /admin[*] path
                'permission' => [
                    'middleware' => [Middleware\AdminAuth::class],
                    'priority'   => 100,
                    'path'       => '/admin'
                ],

                'error404' => [
                    'middleware' => [
                        \Zend\Expressive\Middleware\NotFoundHandler::class
                    ],
                    'priority'   => -10,
                ],
            ],

        ];
    }
}
