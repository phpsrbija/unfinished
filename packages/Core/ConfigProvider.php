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
        ];
    }
}
