<?php

namespace Core;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    Service\MeetupApiService::class => Service\MeetupApiServiceFactory::class,
                ],
            ],

            'middleware_pipeline' => [
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
