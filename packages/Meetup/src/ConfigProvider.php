<?php

namespace Meetup;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    MeetupApiService::class => MeetupApiServiceFactory::class,
                ],
            ],
        ];
    }
}
